<?php
/**
 * Success Cases / Testimonials Section (住み続け隊)
 *
 * - 4 static cases for MVP
 * - Modern carousel display with navigation
 * - Category icons and property images
 * - JSON-LD Review schema included for rich results
 * - Mobile optimized layout
 */

// Define the case data array
$success_cases = [
  [
    'id' => 1,
    'category' => '住宅ローン滞納',
    'icon' => 'home',
    'color' => '#e74c3c',
    'profile' => 'H.T様 （65歳・自営業引退／夫婦2人）',
    'property' => 'マンション 68㎡　築12年（東京都板橋区）',
    'need' => '住宅ローンを3か月連続で滞納。金融機関から「競売手続き開始」の通知が届き、<strong>90日以内に約560万円</strong>を用意しなければ退去の危機。',
    'before' => [
      '住宅ローン残高' => '2,800 万円',
      '月々の返済' => '11.3 万円',
      '手元資金' => '50 万円'
    ],
    'after' => [
      '住宅ローン残高' => '0 円',
      '賃料' => '9.2 万円',
      '手元資金' => '610 万円'
    ],
    'story' => '「老後に家を失うのでは」と眠れない日々。<strong>住み続け隊が5社に一括交渉</strong>し、想定より15％高い売却額に。返済も完了し、退去せずに夫婦の暮らしを守れました。',
    'quote' => 'あと3か月で競売…という恐怖から解放されました',
    'rating' => 5,
    'image' => 'assets/images/case1-mansion.jpg',
    'image_position' => 'light 40%', // 個別調整: 人物が見えるように
  ],
  [
    'id' => 2,
    'category' => '事業資金',
    'icon' => 'briefcase',
    'color' => '#3498db',
    'profile' => 'S.K様 （42歳・飲食店オーナー／妻＋子2人）',
    'property' => '木造戸建て 96㎡　築22年（大阪府吹田市）',
    'need' => '2号店開業チャンスが到来。しかし金融機関の融資審査は最短でも1.5か月待ち。<strong>開業予定日まで4週間</strong>しかない──。',
    'before' => [
      '必要資金' => '1,000 万円',
      '借入金利' => '実質年 2.9 %',
      '毎月返済' => '15 万円 予定'
    ],
    'after' => [
      '資金状況' => 'クリア',
      '金利' => '―',
      '賃料' => '10.8 万円'
    ],
    'story' => '「チャンスを逃したくない」一心で相談。<strong>48時間で契約→着金</strong>でき、予定通りオープン。家族も店も守れました。',
    'quote' => '銀行よりスピードが桁違い！',
    'rating' => 5,
    'image' => 'assets/images/case2-house.jpg',
    'image_position' => 'center 35%', // 建物全体が見えるように
  ],
  [
    'id' => 3,
    'category' => '介護費用',
    'icon' => 'heart',
    'color' => '#9b59b6',
    'profile' => 'M.Y様 （53歳・会社員／母親と同居）',
    'property' => 'マンション 54㎡　築18年（神奈川県横浜市）',
    'need' => '認知症の母を24h 介護できず、<strong>入居一時金400万円</strong>が急ぎで必要。',
    'before' => [
      '一時金資金' => '120 万円 不足',
      '月々家計' => '賃貸移転なら +7 万円',
      '感情負担' => '同居の限界'
    ],
    'after' => [
      '資金状況' => '確保',
      '家賃' => '7.4 万円', 
      '生活環境' => '在宅＋施設の両立'
    ],
    'story' => '住み慣れた家を離れずに母の介護を両立できる道を提案してもらい、<strong>涙が出るほど安心</strong>しました。',
    'quote' => '"家も母も守れた" これ以上の選択肢はありません',
    'rating' => 5,
    'image' => 'assets/images/case3-condo.jpg',
    'image_position' => 'center 35%', // 人物重視の配置
  ],
  [
    'id' => 4,
    'category' => '学費',
    'icon' => 'graduation-cap',
    'color' => '#2ecc71',
    'profile' => 'T.I様 （48歳・公務員／妻＋高校3年の長女）',
    'property' => '鉄骨戸建て 110㎡　築20年（愛知県名古屋市）',
    'need' => '国公立に合格した娘の<strong>4年間学費＋仕送り 約650万円</strong>を一括で用意したい。教育ローンは金利と手続きがネック。',
    'before' => [
      '必要総額' => '650 万円',
      '月々返済' => 'なし',
      '将来の買戻し' => '―'
    ],
    'after' => [
      '資金状況' => '全額確保',
      '賃料' => '8.6 万円',
      '買戻し' => '5年以内に優先権'
    ],
    'story' => '進学祝いと同時に資金不安が消え、<strong>「思いっきり学んで来い」と背中を押せました</strong>。買戻し優先権付きで家族の将来設計もキープ。',
    'quote' => '娘の夢を金銭面で諦めさせずに済んだ！',
    'rating' => 5,
    'image' => 'assets/images/case4-house.jpg',
    'image_position' => 'center 32%', // 家族が見えるように上部重視
  ]
];
?>

<section id="success-cases" class="success-cases">
  <div class="container">
    <div class="sc-header">
      <h2 class="sc-title">利用者の声</h2>
      <p class="sc-summary">
        総合満足度 <span class="rate">4.8 / 5.0</span>
        （<span class="percentage">98%</span> が「また利用したい」と回答）
      </p>
    </div>

    <div class="sc-carousel">
      <!-- Navigation Arrows -->
      <button class="sc-nav sc-nav-prev" aria-label="前のケースを見る">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>
      
      <button class="sc-nav sc-nav-next" aria-label="次のケースを見る">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>

      <!-- Testimonial Cards -->
      <div class="sc-slides">
        <?php foreach ($success_cases as $index => $case): ?>
          <div class="sc-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>">
            <div class="sc-card">
              <div class="sc-card-inner">
                <!-- Image Column -->
                <div class="sc-image-col">
                  <img src="<?php echo esc_url(get_theme_file_uri($case['image'])); ?>" 
                       alt="<?php echo esc_attr($case['category']); ?>の事例" 
                       class="sc-property-img"
                       style="object-position: <?php echo isset($case['image_position']) ? $case['image_position'] : 'center 20%'; ?>">
                  <div class="sc-category" style="--category-color: <?php echo $case['color']; ?>">
                    <span class="sc-icon sc-icon-<?php echo $case['icon']; ?>"></span>
                    <span class="sc-category-text"><?php echo $case['category']; ?></span>
                  </div>
                </div>
                
                <!-- Content Column -->
                <div class="sc-content-col">
                  <!-- Header -->
                  <div class="sc-content-header">
                    <div class="sc-rating">
                      <?php for ($i = 0; $i < 5; $i++): ?>
                        <span class="sc-star <?php echo $i < $case['rating'] ? 'sc-star-filled' : ''; ?>"></span>
                      <?php endfor; ?>
                    </div>
                    <blockquote class="sc-quote">"<?php echo $case['quote']; ?>"</blockquote>
                    <div class="sc-profile"><?php echo $case['profile']; ?></div>
                    <div class="sc-property-detail"><?php echo $case['property']; ?></div>
                  </div>
                  
                  <!-- Burning Need -->
                  <div class="sc-need">
                    <?php echo $case['need']; ?>
                  </div>
                  
                  <!-- Before/After -->
                  <div class="sc-comparison">
                    <h4 class="sc-comparison-title">Before / After 比較</h4>
                    <div class="sc-comparison-table">
                      <div class="sc-comparison-row sc-comparison-header">
                        <div class="sc-comparison-cell"></div>
                        <div class="sc-comparison-cell">売却前</div>
                        <div class="sc-comparison-cell">リースバック後</div>
                      </div>
                      
                      <?php 
                      $before_keys = array_keys($case['before']);
                      foreach ($before_keys as $i => $key): 
                      ?>
                        <div class="sc-comparison-row">
                          <div class="sc-comparison-cell"><?php echo $key; ?></div>
                          <div class="sc-comparison-cell"><?php echo $case['before'][$key]; ?></div>
                          <div class="sc-comparison-cell sc-highlight"><?php echo array_values($case['after'])[$i]; ?></div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  
                  <!-- Story -->
                  <div class="sc-story">
                    <?php echo $case['story']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <!-- Dots -->
      <div class="sc-dots">
        <?php foreach ($success_cases as $index => $case): ?>
          <button 
            class="sc-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
            data-slide="<?php echo $index; ?>"
            aria-label="事例 <?php echo $index + 1; ?> に移動">
          </button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- JSON-LD Review Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "itemListElement": [
    <?php foreach ($success_cases as $index => $case): ?>
    {
      "@type": "Review",
      "author": {"@type":"Person","name":"<?php echo substr($case['profile'], 0, strpos($case['profile'], '様')); ?>"},
      "itemReviewed": {"@type":"Product","name":"住み続け隊 リースバック"},
      "reviewRating": {"@type":"Rating","ratingValue":"<?php echo $case['rating']; ?>","bestRating":"5"},
      "reviewBody": "<?php echo $case['quote']; ?>",
      "image": "<?php echo get_theme_file_uri($case['image']); ?>",
      "datePublished": "2025-05-13"
    }<?php echo ($index < count($success_cases) - 1) ? ',' : ''; ?>
    <?php endforeach; ?>
  ]
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('Carousel script loaded'); // Debug log
  
  // Get all necessary elements
  const slides = document.querySelectorAll('.sc-slide');
  const dots = document.querySelectorAll('.sc-dot');
  const prevButton = document.querySelector('.sc-nav-prev');
  const nextButton = document.querySelector('.sc-nav-next');
  const carousel = document.querySelector('.sc-carousel');
  const slidesContainer = document.querySelector('.sc-slides');
  
  console.log('Found elements:', { slides: slides.length, dots: dots.length, prevButton, nextButton }); // Debug log
  
  // Check if elements exist
  if (!slides.length || !dots.length || !prevButton || !nextButton) {
    console.error('Required carousel elements not found');
    return;
  }
  
  const totalSlides = slides.length;
  let currentSlide = 0;
  let autoSlideInterval;
  
  // Function to show a specific slide
  function showSlide(index) {
    console.log('Showing slide:', index); // Debug log
    
    // Ensure index is within bounds
    if (index < 0) index = totalSlides - 1;
    if (index >= totalSlides) index = 0;
    
    // Hide all slides
    slides.forEach((slide, i) => {
      slide.classList.remove('active');
      slide.style.display = 'none';
    });
    
    // Deactivate all dots
    dots.forEach(dot => {
      dot.classList.remove('active');
    });
    
    // Show the selected slide
    if (slides[index]) {
      slides[index].style.display = 'block';
      // Use requestAnimationFrame for smooth animation
      requestAnimationFrame(() => {
        slides[index].classList.add('active');
      });
    }
    
    // Activate the corresponding dot
    if (dots[index]) {
      dots[index].classList.add('active');
    }
    
    // Update current slide index
    currentSlide = index;
  }
  
  // Add click event to dots
  dots.forEach((dot, index) => {
    dot.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Dot clicked:', index); // Debug log
      handleUserInteraction();
      showSlide(index);
    });
  });
  
  // Add click event to prev button
  if (prevButton) {
    prevButton.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Prev button clicked'); // Debug log
      handleUserInteraction();
      showSlide(currentSlide - 1);
    });
  }
  
  // Add click event to next button
  if (nextButton) {
    nextButton.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Next button clicked'); // Debug log
      handleUserInteraction();
      showSlide(currentSlide + 1);
    });
  }
  
  // Auto-advance slides
  function startAutoSlide() {
    clearAutoSlide(); // 既存のタイマーをクリア
    autoSlideInterval = setInterval(() => {
      showSlide(currentSlide + 1);
    }, 12000); // 12秒間隔に変更（元の8秒から延長）
  }
  
  function clearAutoSlide() {
    if (autoSlideInterval) {
      clearInterval(autoSlideInterval);
      autoSlideInterval = null; // 明示的にnullに設定
    }
  }
  
  // Pause auto-advance on hover (より安定した制御)
  if (carousel) {
    carousel.addEventListener('mouseenter', () => {
      clearAutoSlide();
    });
    
    carousel.addEventListener('mouseleave', () => {
      // 少し遅延を入れてから再開
      setTimeout(() => {
        startAutoSlide();
      }, 500);
    });
  }
  
  // ユーザー操作時の自動再生制御を改善
  function handleUserInteraction() {
    clearAutoSlide();
    // ユーザー操作後、少し長めの間隔で自動再生を再開
    setTimeout(() => {
      startAutoSlide();
    }, 2000); // 2秒後に自動再生再開
  }
  
  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft' && prevButton) {
      e.preventDefault();
      handleUserInteraction();
      showSlide(currentSlide - 1);
    } else if (e.key === 'ArrowRight' && nextButton) {
      e.preventDefault();
      handleUserInteraction();
      showSlide(currentSlide + 1);
    }
  });
  
  // Touch/swipe support for mobile (improved scroll handling)
  let touchStartX = 0;
  let touchStartY = 0;
  let touchEndX = 0;
  let touchEndY = 0;
  let isHorizontalSwipe = false;
  let touchMoved = false;
  
  if (slidesContainer) {
    slidesContainer.addEventListener('touchstart', function(e) {
      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
      touchMoved = false;
      isHorizontalSwipe = false;
    }, { passive: true });
    
    slidesContainer.addEventListener('touchmove', function(e) {
      if (!touchMoved) {
        const currentX = e.touches[0].clientX;
        const currentY = e.touches[0].clientY;
        const deltaX = Math.abs(currentX - touchStartX);
        const deltaY = Math.abs(currentY - touchStartY);
        
        // 移動距離が10px以上になったら方向を判定
        if (deltaX > 10 || deltaY > 10) {
          touchMoved = true;
          
          // 横方向の移動が縦方向より大きく、かつ30px以上の場合のみ横スワイプと判定
          if (deltaX > deltaY && deltaX > 30) {
            isHorizontalSwipe = true;
            e.preventDefault(); // 横スワイプの場合のみスクロールを防止
          }
        }
      } else if (isHorizontalSwipe) {
        e.preventDefault(); // 横スワイプ中はスクロールを防止
      }
      // 縦スワイプの場合は何もしない（デフォルトのスクロール動作を許可）
    }, { passive: false });
    
    slidesContainer.addEventListener('touchend', function(e) {
      if (!touchMoved || !isHorizontalSwipe) {
        // 移動していない、または縦スワイプの場合は何もしない
        return;
      }
      
      touchEndX = e.changedTouches[0].clientX;
      touchEndY = e.changedTouches[0].clientY;
      
      const deltaX = touchStartX - touchEndX;
      const deltaY = Math.abs(touchStartY - touchEndY);
      
      // 横方向の移動が50px以上で、縦方向の移動より大きい場合のみスライド切り替え
      if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > deltaY) {
        handleUserInteraction();
        
        if (deltaX > 0) {
          // Swipe left - next slide
          showSlide(currentSlide + 1);
        } else {
          // Swipe right - previous slide
          showSlide(currentSlide - 1);
        }
      }
      
      // Reset touch positions and flags
      touchStartX = 0;
      touchStartY = 0;
      touchEndX = 0;
      touchEndY = 0;
      isHorizontalSwipe = false;
      touchMoved = false;
    }, { passive: true });
  }
  
  // Initialize the carousel
  function initCarousel() {
    console.log('Initializing carousel'); // Debug log
    
    // Hide all slides first
    slides.forEach((slide, index) => {
      slide.style.display = 'none';
      slide.classList.remove('active');
    });
    
    // Show first slide
    showSlide(0);
    
    // Start auto-advance
    startAutoSlide();
  }
  
  // Initialize
  initCarousel();
  
  // Cleanup on page unload
  window.addEventListener('beforeunload', () => {
    clearAutoSlide();
  });
});
</script>