<?php
/**
 * 🔥 改修版 - フォーム記録漏れ対策完全版（統合的データ処理）
 */

if (!defined('ABSPATH')) {
    exit;
}

// AJAX ハンドラー（統合版データベース保存付き）
add_action('admin_post_nopriv_lead_submit', 'enhanced_lead_submit');
add_action('admin_post_lead_submit', 'enhanced_lead_submit');

function enhanced_lead_submit() {
    try {
        // 🔥 全受信データのログ出力
        error_log('🔍 受信した全POSTデータ: ' . print_r($_POST, true));
        
        // nonce検証
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if (empty($nonce) || !wp_verify_nonce($nonce, 'lead_form_nonce')) {
            throw new Exception('セキュリティ検証失敗');
        }
        
        // 🔥 統合的なフィールド定義（基本＋詳細）
        $all_fields = array(
            // 基本情報
            'zip', 'property-type', 'pref', 'city', 'town', 'chome', 
            'banchi', 'building_name', 'room_number',
            'name', 'tel', 'email', 'remarks',
            
            // 物件詳細
            'layout_rooms', 'layout_type', 
            'area', 'area_unit', 'building_area', 'building_area_unit', 
            'land_area', 'land_area_unit', 'age', 'other_type', 'total_units',
            'land_remarks'
        );
        
        // 🔥 確実なデータ取得
        $collected_data = array();
        
        foreach ($all_fields as $field_name) {
            $value = '';
            
            if (isset($_POST[$field_name])) {
                $raw_value = wp_unslash($_POST[$field_name]);
                $value = sanitize_text_field($raw_value);
            }
            
            $collected_data[$field_name] = $value;
            
            // 🔥 重要フィールドのログ出力
            if (in_array($field_name, ['banchi', 'building_name', 'room_number', 'name', 'tel', 'email', 'area', 'age'])) {
                error_log("📝 フィールド[{$field_name}]: '{$value}'");
            }
        }
        
        // 🔥 必須チェック（より詳細に）
        $required_fields = ['name', 'tel', 'email', 'banchi'];
        
        foreach ($required_fields as $required_field) {
            if (empty($collected_data[$required_field])) {
                error_log("❌ 必須フィールド未入力: {$required_field}");
                throw new Exception("必須項目「{$required_field}」が入力されていません");
            }
        }
        
        // 🔥 データベース保存（統合版）
        $post_data = array(
            'post_type'   => 'lead',
            'post_status' => 'publish',
            'post_title'  => $collected_data['name'] . ' - ' . current_time('Y-m-d H:i:s'),
            'post_content' => ''
        );
        
        $lead_id = wp_insert_post($post_data, true);
        
        if (is_wp_error($lead_id)) {
            throw new Exception('データベース保存エラー: ' . $lead_id->get_error_message());
        }
        
        if (!$lead_id) {
            throw new Exception('データベース保存失敗');
        }
        
        // 🔥 メタデータ保存（空文字列も保存）
        foreach ($collected_data as $meta_key => $meta_value) {
            update_post_meta($lead_id, $meta_key, $meta_value);
            error_log("💾 メタデータ保存: {$meta_key} = '{$meta_value}'");
        }
        
        // 🔥 住所組み立て（確実版）
        $full_address = trim(
            $collected_data['pref'] . ' ' .
            $collected_data['city'] . ' ' .
            $collected_data['town'] . ' ' .
            $collected_data['chome'] . '丁目 ' .
            $collected_data['banchi'] . ' ' .
            $collected_data['building_name'] . ' ' .
            $collected_data['room_number']
        );
        
        // 完全住所もメタデータとして保存
        update_post_meta($lead_id, 'full_address', $full_address);
        
        error_log("🏠 完全住所: {$full_address}");
        
        // メール送信テスト
        $mail_success = false;
        try {
            $mail_success = send_enhanced_notification_email($collected_data, $lead_id);
        } catch (Exception $mail_error) {
            error_log('メール送信エラー: ' . $mail_error->getMessage());
        }
        
        // スプレッドシート送信テスト
        $sheet_success = false;
        try {
            $sheet_success = send_to_enhanced_spreadsheet($collected_data);
        } catch (Exception $sheet_error) {
            error_log('スプレッドシート送信エラー: ' . $sheet_error->getMessage());
        }
        
        // 成功レスポンス
        header('Content-Type: application/json');
        echo json_encode(array(
            'success' => true,
            'data' => array(
                'message' => 'すべての処理が完了しました！',
                'lead_id' => $lead_id,
                'customer_name' => $collected_data['name'],
                'mail_sent' => $mail_success,
                'sheet_sent' => $sheet_success,
                'collected_fields_count' => count(array_filter($collected_data)) // 空でないフィールド数
            )
        ));
        
    } catch (Exception $e) {
        error_log('❌ 処理エラー詳細: ' . $e->getMessage());
        
        // エラーレスポンス
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(array(
            'success' => false,
            'data' => array(
                'message' => 'エラー: ' . $e->getMessage()
            )
        ));
    }
    
    exit;
}

// 🔥 強化されたメール送信関数
function send_enhanced_notification_email($data, $lead_id) {
    try {
        $to = 'info@sumitsuzuke-tai.jp';
        
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('送信先メールアドレスが無効');
        }
        
        $subject = '【住み続け隊】新しい査定依頼 #' . $lead_id;
        
        // 🔥 物件種別の日本語表示
        $property_type_names = array(
            'mansion-unit' => 'マンション（区分）',
            'house' => '一戸建て',
            'land' => '土地',
            'mansion-building' => 'マンション一棟',
            'building' => 'ビル一棟',
            'apartment-building' => 'アパート一棟',
            'other' => 'その他'
        );
        $property_type_display = isset($property_type_names[$data['property-type']]) 
            ? $property_type_names[$data['property-type']] 
            : $data['property-type'];

        // 🔥 住所の組み立て
        $full_address = trim(
            $data['pref'] . ' ' .
            $data['city'] . ' ' .
            $data['town'] . ' ' .
            $data['chome'] . '丁目 ' .
            $data['banchi'] . ' ' .
            $data['building_name'] . ' ' .
            $data['room_number']
        );

        $body = "【基本情報】\n";
        $body .= "Lead ID: {$lead_id}\n";
        $body .= "郵便番号: {$data['zip']}\n";
        $body .= "物件種別: {$property_type_display}\n";
        $body .= "住所: {$full_address}\n";
        
        $body .= "\n【詳細住所】\n";
        $body .= "番地・号: {$data['banchi']}\n";
        $body .= "建物名: {$data['building_name']}\n";
        $body .= "部屋番号: {$data['room_number']}\n";
        
        $body .= "\n【物件詳細】\n";
        if (!empty($data['layout_rooms']) && !empty($data['layout_type'])) {
            $body .= "間取り: {$data['layout_rooms']}{$data['layout_type']}\n";
        }
        
        if (!empty($data['area'])) {
            $area_unit = !empty($data['area_unit']) ? $data['area_unit'] : '㎡';
            $body .= "専有面積: {$data['area']}{$area_unit}\n";
        }
        
        if (!empty($data['building_area'])) {
            $building_area_unit = !empty($data['building_area_unit']) ? $data['building_area_unit'] : '㎡';
            $body .= "建物面積: {$data['building_area']}{$building_area_unit}\n";
        }
        
        if (!empty($data['land_area'])) {
            $land_area_unit = !empty($data['land_area_unit']) ? $data['land_area_unit'] : '㎡';
            $body .= "土地面積: {$data['land_area']}{$land_area_unit}\n";
        }
        
        if (!empty($data['age'])) {
            $age_display = ($data['age'] === '31') ? '31年以上・正確に覚えていない' : $data['age'] . '年';
            $body .= "築年数: {$age_display}\n";
        }
        
        if (!empty($data['other_type'])) {
            $body .= "種類: {$data['other_type']}\n";
        }
        
        if (!empty($data['total_units'])) {
            $body .= "総戸数: {$data['total_units']}\n";
        }
        
        $body .= "\n【お客様情報】\n";
        $body .= "お名前: {$data['name']}\n";
        $body .= "電話: {$data['tel']}\n";
        $body .= "メール: {$data['email']}\n";
        
        if (!empty($data['remarks'])) {
            $body .= "\n【ご要望・備考】\n";
            $body .= $data['remarks'] . "\n";
        }
        
        if (!empty($data['land_remarks'])) {
            $body .= "\n【土地備考】\n";
            $body .= $data['land_remarks'] . "\n";
        }
        
        $body .= "\n---\n";
        $body .= "投稿日時: " . current_time('Y-m-d H:i:s') . "\n";
        $body .= "管理画面: " . admin_url("post.php?post={$lead_id}&action=edit") . "\n";
        
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: 住み続け隊査定フォーム <info@sumitsuzuke-tai.jp>'
        );
        
        $result = wp_mail($to, $subject, $body, $headers);
        
        error_log('📧 メール送信結果: ' . ($result ? '成功' : '失敗'));
        
        return $result;
        
    } catch (Exception $e) {
        error_log('📧 メール送信例外: ' . $e->getMessage());
        return false;
    }
}

// 🔥 強化されたスプレッドシート送信関数
function send_to_enhanced_spreadsheet($data) {
    try {
        $url = 'https://script.google.com/macros/s/AKfycbx-FDuymWxq4yyCN5eWXxpqnbmx7pCe4loaPzpYn41vccjt4_ceM7wmA1Qf_NV3Mmvz/exec';
        
        // 🔥 完全住所の組み立て
        $full_address = trim(
            $data['pref'] . ' ' .
            $data['city'] . ' ' .
            $data['town'] . ' ' .
            $data['chome'] . '丁目 ' .
            $data['banchi'] . ' ' .
            $data['building_name'] . ' ' .
            $data['room_number']
        );
        
        // 🔥 送信データの準備（全フィールド）
        $send_data = $data;
        $send_data['secret'] = 'sumitsu2025';
        $send_data['full_address'] = $full_address;
        $send_data['timestamp'] = current_time('Y-m-d H:i:s');
        
        // 🔥 送信前ログ
        error_log('📊 スプレッドシート送信データ: ' . print_r($send_data, true));
        
        $response = wp_remote_post($url, array(
            'body' => $send_data,
            'timeout' => 15,
            'sslverify' => false
        ));
        
        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }
        
        $code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        
        error_log("📊 スプレッドシート送信結果: Code:{$code}, Body:{$body}");
        
        return $code === 200;
        
    } catch (Exception $e) {
        error_log('📊 スプレッドシート送信例外: ' . $e->getMessage());
        return false;
    }
}

// リードカスタム投稿タイプ
add_action('init', function() {
    register_post_type('lead', array(
        'labels' => array('name' => '査定依頼', 'singular_name' => '査定依頼'),
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array('title'),
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ));
});

// 基本設定
add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});

// スクリプト（住所自動入力機能付き）
add_action('wp_enqueue_scripts', function() {
    // 共通ライブラリ
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap', array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');
    
    // メインCSS
    wp_enqueue_style('sumitsuzuketai-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // jQuery
    wp_enqueue_script('jquery');
    wp_enqueue_script('sumitsuzuketai-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    if (is_page_template('template-parts/lead-form.php') || 
        (isset($_GET['template']) && $_GET['template'] === 'lead-form')) {
        
        // リードフォーム専用CSS（インライン出力）
        wp_add_inline_style('sumitsuzuketai-style', get_lead_form_css());
        
        // リードフォーム専用JS
        wp_enqueue_script('lead-form-js', get_template_directory_uri() . '/dist/js/lead.js', array(), '1.0.0', true);
        
        wp_localize_script('lead-form-js', 'leadFormAjax', array(
            'ajaxurl' => admin_url('admin-post.php'),
            'nonce'   => wp_create_nonce('lead_form_nonce'),
            'action'  => 'lead_submit'
        ));
    }
});

// リードフォーム用CSS
function get_lead_form_css() {
    return '
.lead-form {
  padding: clamp(60px, 8vw, 100px) 0;
  background: #f7f8fc;
  min-height: 100vh;
}

.lead-form .container { 
  max-width: 820px; 
  margin: 0 auto;
  padding: 0 20px;
}

.form-wrapper {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,.05);
  padding: clamp(28px,6vw,40px);
}

.lead-title {
  font-size: clamp(22px,6vw,30px);
  font-weight: 700;
  margin-bottom: 28px;
  text-align: center;
}

/* プログレスメーター */
.progress-container {
  margin-bottom: 40px;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e9ecef;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 20px;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #0066cc, #0099ff);
  border-radius: 4px;
  transition: width 0.3s ease;
  width: 33.33%;
}

.step-indicators {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.step-indicator {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
  position: relative;
}

.step-number {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
  margin-bottom: 8px;
  transition: all 0.3s ease;
}

.step-indicator.active .step-number {
  background: #0066cc;
  color: white;
}

.step-indicator.completed .step-number {
  background: #28a745;
  color: white;
}

.step-indicator:not(.active):not(.completed) .step-number {
  background: #e9ecef;
  color: #6c757d;
}

.step-label {
  font-size: 12px;
  color: #666;
  text-align: center;
  font-weight: 500;
}

.step-indicator.active .step-label {
  color: #0066cc;
  font-weight: 700;
}

/* ステップコンテンツ */
.step-content {
  display: none;
}

.step-content.active {
  display: block;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* フォーム要素 */
fieldset { 
  border: none; 
  margin-bottom: 36px; 
}

legend {
  font-size: 18px; 
  font-weight: 700; 
  color: #0066cc;
  margin-bottom: 18px;
}

.form-row { 
  display: flex; 
  flex-wrap: wrap; 
  gap: 18px; 
  margin-bottom: 18px;
}

.two-col > * { 
  flex: 1 1 calc(50% - 9px); 
}

/* 🔥 3列レイアウト */
.three-col {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.three-col > * { 
  flex: 1 1 calc(33.33% - 8px); 
  min-width: 0;
}

.form-group { 
  flex: 1 1 100%; 
  min-width: 0; 
}

.form-group label { 
  display: block; 
  font-weight: 700; 
  margin-bottom: 6px; 
  color: #333; 
}

.req { 
  color: #d00; 
  font-size: .8em; 
  margin-left: 4px; 
}

.form-group input, .form-group select, .form-group textarea {
  width: 100%; 
  padding: 14px 15px;
  border: 2px solid #ddd; 
  border-radius: 6px;
  font-size: 16px; 
  transition: .2s;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
  border-color: #0066cc; 
  box-shadow: 0 0 3px rgba(0,102,204,.24); 
  outline: none;
}

input.readonly { 
  background: #f5f5f5; 
  cursor: not-allowed; 
}

/* 面積入力のユニット切り替え */
.unit-toggle {
  display: flex;
  gap: 8px;
  margin-bottom: 8px;
}

.unit-toggle label {
  display: flex;
  align-items: center;
  gap: 4px;
  font-weight: normal;
  margin-bottom: 0;
  cursor: pointer;
}

.unit-toggle input[type="radio"] {
  width: auto;
}

.area-input-group {
  position: relative;
}

.area-input-group input {
  padding-right: 50px;
}

.area-unit {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
  font-weight: 500;
}

/* 間取り入力 */
.layout-input {
  display: flex;
  gap: 12px;
  align-items: center;
  flex-wrap: wrap;
}

.layout-rooms, .layout-type {
  flex: 1;
  min-width: 120px;
}

.note {
  font-size: 12px;
  color: #666;
  margin-top: 4px;
  font-style: italic;
}

/* テキストエリア */
textarea {
  resize: vertical;
  min-height: 100px;
  font-family: inherit;
}

.agree { 
  font-size: 14px; 
  display: flex; 
  align-items: flex-start;
  gap: 8px;
}

.agree input[type="checkbox"] {
  width: auto;
  margin-top: 4px;
}

.agree a { 
  color: #0066cc; 
  text-decoration: underline; 
}

/* ボタン */
.button-group {
  display: flex;
  gap: 12px;
  justify-content: space-between;
  margin-top: 30px;
}

.btn {
  padding: 15px 30px;
  font-size: 16px;
  font-weight: 700;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  flex: 1;
}

.btn-prev {
  background: #6c757d;
  color: white;
}

.btn-prev:hover {
  background: #5a6268;
}

.btn-next, .btn-submit {
  background: #ff6600;
  color: white;
}

.btn-next:hover, .btn-submit:hover {
  background: #e55a00;
}

.btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* サンクスモーダル */
.thanks-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.thanks-modal.show {
  opacity: 1;
  visibility: visible;
}

.thanks-modal-content {
  background: white;
  border-radius: 16px;
  padding: 40px;
  max-width: 500px;
  width: 90%;
  text-align: center;
  transform: scale(0.8);
  transition: transform 0.3s ease;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.thanks-modal.show .thanks-modal-content {
  transform: scale(1);
}

.thanks-icon {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #28a745, #20c997);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 24px;
  font-size: 40px;
  color: white;
}

.thanks-title {
  font-size: 24px;
  font-weight: 700;
  color: #333;
  margin-bottom: 16px;
}

.thanks-message {
  font-size: 16px;
  color: #666;
  line-height: 1.6;
  margin-bottom: 32px;
}

.thanks-buttons {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}

.thanks-btn {
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.2s ease;
  border: none;
  cursor: pointer;
  font-size: 14px;
}

.thanks-btn-primary {
  background: #0066cc;
  color: white;
}

.thanks-btn-primary:hover {
  background: #0052a3;
  color: white;
}

.thanks-btn-secondary {
  background: #f8f9fa;
  color: #666;
  border: 2px solid #dee2e6;
}

.thanks-btn-secondary:hover {
  background: #e9ecef;
  color: #495057;
}

/* 送信中オーバーレイ */
.form-sending {
  position: relative;
}

.form-sending::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.form-sending::before {
  content: "送信中...";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #0066cc;
  color: white;
  padding: 16px 24px;
  border-radius: 8px;
  font-weight: 600;
  z-index: 1001;
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

/* レスポンシブ */
@media (max-width: 768px) {
  .two-col {
    flex-direction: column;
  }
  
  .two-col > * {
    flex: 1 1 100%;
  }

  /* 🔥 3列レイアウトのモバイル対応（横並び維持） */
  .three-col {
    gap: 8px;
  }
  
  .three-col > * {
    flex: 1 1 calc(33.33% - 5px);
    min-width: 0;
  }

  .three-col .form-group label {
    font-size: 14px;
    margin-bottom: 4px;
  }
  
  .three-col .form-group input {
    padding: 12px 10px;
    font-size: 14px;
  }

  .step-label {
    font-size: 10px;
  }

  .step-number {
    width: 32px;
    height: 32px;
    font-size: 12px;
  }

  .layout-input {
    flex-direction: column;
  }

  .layout-rooms, .layout-type {
    min-width: 100%;
  }

  .thanks-modal-content {
    padding: 32px 24px;
    margin: 20px;
  }
  
  .thanks-title {
    font-size: 20px;
  }
  
  .thanks-message {
    font-size: 14px;
  }
  
  .thanks-buttons {
    flex-direction: column;
  }
  
  .thanks-btn {
    width: 100%;
    padding: 14px 24px;
  }
}

@media (max-width: 480px) {
  /* 🔥 最小画面でも3列横並び維持 */
  .three-col {
    gap: 6px;
  }
  
  .three-col > * {
    flex: 1 1 calc(33.33% - 4px);
    min-width: 0;
  }

  .three-col .form-group label {
    font-size: 12px;
    margin-bottom: 3px;
  }
  
  .three-col .form-group input {
    padding: 10px 8px;
    font-size: 14px;
  }
}
';
}

// FAQ アコーディオン用 jQuery
add_action('wp_enqueue_scripts', function() {
    wp_add_inline_script('jquery-core', '
        jQuery(function ($) {
            $(".faq-question").on("click", function () {
                const $item = $(this).closest(".faq-item");
                $(".faq-item.active").not($item).removeClass("active");
                $item.toggleClass("active");
            });
        });
    ', 'after');
}, 99);

// ショートコード
add_action('init', function() {
    $sections = array(
        'header-firstview', 'user-benefits', 'partner-companies', 'process-steps',
        'success-cases', 'realtime-status', 'main-form', 'faq', 'concierge',
        'seo-content', 'reviews', 'final-cta',
    );
    
    foreach ($sections as $slug) {
        add_shortcode($slug, function($atts, $content = null, $tag = '') use ($slug) {
            $template_path = locate_template("template-parts/{$slug}.php", false, false);
            if ($template_path) {
                ob_start();
                include $template_path;
                return ob_get_clean();
            }
            return '';
        });
    }
});

/* ======================================================
 * 🔥 管理画面での査定依頼詳細表示（統合版）
 * ====================================================== */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'lead_details',
        '査定依頼詳細',
        'enhanced_lead_details_meta_box',
        'lead'
    );
});

function enhanced_lead_details_meta_box($post) {
    $meta = get_post_meta($post->ID);
    
    echo '<table class="form-table">';
    
    // 基本情報
    echo '<tr><th colspan="2"><strong>📍 基本情報</strong></th></tr>';
    $basic_fields = array(
        'zip' => '郵便番号',
        'property-type' => '物件種別',
        'pref' => '都道府県',
        'city' => '市区町村',
        'town' => '町名',
        'chome' => '丁目'
    );
    
    foreach ($basic_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        // 物件種別の日本語表示
        if ($key === 'property-type' && $value) {
            $property_type_names = array(
                'mansion-unit' => 'マンション（区分）',
                'house' => '一戸建て',
                'land' => '土地',
                'mansion-building' => 'マンション一棟',
                'building' => 'ビル一棟',
                'apartment-building' => 'アパート一棟',
                'other' => 'その他'
            );
            $value = isset($property_type_names[$value]) ? $property_type_names[$value] : $value;
        }
        if ($value) {
            echo "<tr><th>{$label}</th><td>" . esc_html($value) . "</td></tr>";
        }
    }
    
    // 🔥 3つの住所フィールド
    echo '<tr><th colspan="2"><strong>🏠 詳細住所</strong></th></tr>';
    
    $banchi = isset($meta['banchi'][0]) ? $meta['banchi'][0] : '';
    $building_name = isset($meta['building_name'][0]) ? $meta['building_name'][0] : '';
    $room_number = isset($meta['room_number'][0]) ? $meta['room_number'][0] : '';
    
    // 🔥 統合版：空文字列でも表示
    echo "<tr><th>番地・号</th><td>" . esc_html($banchi) . "</td></tr>";
    echo "<tr><th>建物名</th><td>" . esc_html($building_name) . "</td></tr>";
    echo "<tr><th>部屋番号</th><td>" . esc_html($room_number) . "</td></tr>";
    
    // 🔥 完全住所表示
    $pref = isset($meta['pref'][0]) ? $meta['pref'][0] : '';
    $city = isset($meta['city'][0]) ? $meta['city'][0] : '';
    $town = isset($meta['town'][0]) ? $meta['town'][0] : '';
    $chome = isset($meta['chome'][0]) ? $meta['chome'][0] : '';
    
    $full_address = trim($pref . ' ' . $city . ' ' . $town . ' ' . $chome . '丁目 ' . $banchi . ' ' . $building_name . ' ' . $room_number);
    
    echo "<tr><th style='background: #e8f4fd;'>完全住所</th><td style='background: #e8f4fd; font-weight: bold;'>" . esc_html($full_address) . "</td></tr>";
    
    // 物件詳細
    echo '<tr><th colspan="2"><strong>🏠 物件詳細</strong></th></tr>';
    
    // 間取り
    $layout_rooms = isset($meta['layout_rooms'][0]) ? $meta['layout_rooms'][0] : '';
    $layout_type = isset($meta['layout_type'][0]) ? $meta['layout_type'][0] : '';
    if ($layout_rooms || $layout_type) {
        echo "<tr><th>間取り</th><td>" . esc_html($layout_rooms . $layout_type) . "</td></tr>";
    }
    
    // 🔥 面積情報（空でも表示）
    $area_fields = array(
        'area' => '専有面積',
        'building_area' => '建物面積',
        'land_area' => '土地面積'
    );
    
    foreach ($area_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        $unit = isset($meta[$key . '_unit'][0]) ? $meta[$key . '_unit'][0] : '㎡';
        
        if ($value || isset($meta[$key][0])) { // メタデータが存在すれば表示
            echo "<tr><th>{$label}</th><td>" . esc_html($value . ($value ? $unit : '')) . "</td></tr>";
        }
    }
    
    // 築年数
    $age = isset($meta['age'][0]) ? $meta['age'][0] : '';
    if ($age || isset($meta['age'][0])) {
        $age_display = $age === '31' ? '31年以上・正確に覚えていない' : ($age ? $age . '年' : '');
        echo "<tr><th>築年数</th><td>" . esc_html($age_display) . "</td></tr>";
    }
    
    // その他種類
    $other_type = isset($meta['other_type'][0]) ? $meta['other_type'][0] : '';
    if ($other_type || isset($meta['other_type'][0])) {
        echo "<tr><th>種類</th><td>" . esc_html($other_type) . "</td></tr>";
    }
    
    // 総戸数
    $total_units = isset($meta['total_units'][0]) ? $meta['total_units'][0] : '';
    if ($total_units || isset($meta['total_units'][0])) {
        echo "<tr><th>総戸数</th><td>" . esc_html($total_units . ($total_units ? '戸' : '')) . "</td></tr>";
    }
    
    // お客様情報
    echo '<tr><th colspan="2"><strong>👤 お客様情報</strong></th></tr>';
    $customer_fields = array(
        'name' => 'お名前',
        'tel' => '電話番号',
        'email' => 'メールアドレス'
    );
    
    foreach ($customer_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        if ($value) {
            // 電話番号とメールアドレスはリンクにする
            if ($key === 'tel') {
                echo "<tr><th>{$label}</th><td><a href='tel:" . esc_attr($value) . "'>" . esc_html($value) . "</a></td></tr>";
            } elseif ($key === 'email') {
                echo "<tr><th>{$label}</th><td><a href='mailto:" . esc_attr($value) . "'>" . esc_html($value) . "</a></td></tr>";
            } else {
                echo "<tr><th>{$label}</th><td>" . esc_html($value) . "</td></tr>";
            }
        }
    }
    
    // 備考
    $remarks = isset($meta['remarks'][0]) ? $meta['remarks'][0] : '';
    if ($remarks || isset($meta['remarks'][0])) {
        echo "<tr><th>ご要望・備考</th><td>" . nl2br(esc_html($remarks)) . "</td></tr>";
    }
    
    // 土地備考
    $land_remarks = isset($meta['land_remarks'][0]) ? $meta['land_remarks'][0] : '';
    if ($land_remarks || isset($meta['land_remarks'][0])) {
        echo "<tr><th>土地備考</th><td>" . nl2br(esc_html($land_remarks)) . "</td></tr>";
    }
    
    // 🔥 データ完全性チェック
    echo '<tr><th colspan="2"><strong>📊 データ完全性</strong></th></tr>';
    
    $all_fields = array(
        'zip', 'property-type', 'pref', 'city', 'town', 'chome', 
        'banchi', 'building_name', 'room_number',
        'name', 'tel', 'email', 'remarks',
        'layout_rooms', 'layout_type', 
        'area', 'area_unit', 'building_area', 'building_area_unit', 
        'land_area', 'land_area_unit', 'age', 'other_type', 'total_units',
        'land_remarks'
    );
    
    $filled_fields = 0;
    $empty_fields = array();
    
    foreach ($all_fields as $field) {
        $value = isset($meta[$field][0]) ? $meta[$field][0] : '';
        if (!empty($value)) {
            $filled_fields++;
        } else {
            $empty_fields[] = $field;
        }
    }
    
    $total_fields = count($all_fields);
    $completion_rate = round(($filled_fields / $total_fields) * 100, 1);
    
    echo "<tr><th>入力完了率</th><td><strong>{$completion_rate}%</strong> ({$filled_fields}/{$total_fields}フィールド)</td></tr>";
    
    if (!empty($empty_fields)) {
        echo "<tr><th>未入力フィールド</th><td style='color: #666; font-size: 12px;'>" . implode(', ', $empty_fields) . "</td></tr>";
    }
    
    // 投稿情報
    echo '<tr><th colspan="2"><strong>📅 投稿情報</strong></th></tr>';
    echo "<tr><th>受付日時</th><td>" . get_the_date('Y年m月d日 H:i:s', $post->ID) . "</td></tr>";
    echo "<tr><th>Lead ID</th><td>" . $post->ID . "</td></tr>";
    
    // 🔥 完全住所をメタデータで確認
    $stored_full_address = isset($meta['full_address'][0]) ? $meta['full_address'][0] : '';
    if ($stored_full_address) {
        echo "<tr><th>保存済み完全住所</th><td style='background: #f0f8ff;'>" . esc_html($stored_full_address) . "</td></tr>";
    }
    
    echo '</table>';
    
    // スタイル追加
    echo '<style>
    .form-table th { background: #f9f9f9; font-weight: bold; width: 150px; }
    .form-table td { padding: 12px; }
    .form-table a { color: #0073aa; text-decoration: none; }
    .form-table a:hover { text-decoration: underline; }
    </style>';
}