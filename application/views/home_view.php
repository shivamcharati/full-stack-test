<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fullstack Task</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; }
    .active-tab { background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .inactive-tab { background-color: white; opacity: 0.8; }

    /* Mobile accordion styles */
    @media (max-width: 768px) {
      .middle-content, .right-image { display: none !important; }
      .accordion-content {
        display: none;
        padding: 1rem;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 0 0 0.5rem 0.5rem;
      }
      .accordion-content.active {
        display: block;
      }
    }
  </style>
</head>
<body class="bg-[#0d3b5b] text-white">

  <!-- Section start -->
  <section class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-semibold text-center">DelphianLogic in Action</h2>
    <p class="text-center mt-2 text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo.</p>

    <div class="mt-8 flex flex-col md:flex-row bg-white/5 rounded-lg overflow-hidden shadow-lg">

      <!-- Column 1: Tabs / Accordions -->
      <div class="bg-gray-100 flex flex-col p-6 space-y-4 md:w-1/4">
        <?php
        foreach ($tabs as $i => $tab) {
          $tabImagePath = 'assets/upload/' . (!empty($tab->image) ? $tab->image : 'default-image.jpg');
          $bgImage = file_exists(FCPATH . $tabImagePath) ? base_url($tabImagePath) : base_url('assets/upload/default-image.jpg');

          $tabIconPath = 'assets/upload/' . (!empty($tab->icon) ? $tab->icon : '');
          $iconImage = (!empty($tab->icon) && file_exists(FCPATH . $tabIconPath)) ? base_url($tabIconPath) : null;
        ?>
          <div class="accordion-item">
            <button 
              class="tab-btn <?= ($i === 0) ? 'active-tab' : 'inactive-tab' ?> flex items-center p-4 rounded transition w-full justify-between"
              data-tab="<?= htmlspecialchars($tab->id) ?>"
              data-bg="<?= $bgImage ?>"
            >
              <span class="flex items-center">
                <?php if ($iconImage) { ?>
                  <img src="<?= $iconImage ?>" style="width:28px;height:28px" class="mr-3" alt="Icon" />
                <?php } ?>
                <span class="text-gray-800 font-semibold"><?= htmlspecialchars($tab->title) ?></span>
              </span>
              <!-- Toggle icon as image -->
              <img 
                class="toggle-icon block md:hidden" 
                src="<?= base_url('files/images/plus-01.svg') ?>" 
                alt="Toggle Icon" 
                style="width:20px; height:20px;" 
              />
            </button>
            <div class="accordion-content md:hidden" id="accordion-<?= htmlspecialchars($tab->id) ?>"></div>
          </div>
        <?php } ?>
      </div>

      <!-- Column 2: Slider Content -->
      <div class="bg-sky-400 flex flex-col justify-center p-8 md:w-2/4 middle-content"></div>

      <!-- Column 3: Image -->
      <div class="md:w-1/4">
        <img class="right-image h-full w-full object-cover" alt="Business Technology" />
      </div>
    </div>
  </section>

  <script>
    var tabData = {};
    <?php
    foreach ($tabs as $tab) {
      echo "tabData['" . htmlspecialchars($tab->id) . "'] = [";
      $slides = property_exists($tab, 'slides') ? $tab->slides : [];
      foreach ($slides as $slide) {
        $slideImagePath = 'assets/upload/' . (!empty($slide->image) ? $slide->image : 'default-slide.jpg');
        $slideImg = file_exists(FCPATH . $slideImagePath) ? base_url($slideImagePath) : base_url('assets/upload/default-slide.jpg');
        echo "{
          tag: " . json_encode($slide->tag ?? '') . ",
          title: " . json_encode($slide->title ?? '') . ",
          img: " . json_encode($slideImg) . "
        },";
      }
      echo "];";
    }
    ?>

    const tabButtons = document.querySelectorAll('.tab-btn');
    const middleContent = document.querySelector('.middle-content');
    const rightImage = document.querySelector('.right-image');

    let currentTab = tabButtons[0] ? tabButtons[0].dataset.tab : null;
    let currentSlide = 0;
    let autoSlideInterval;

    // For mobile accordion auto slide
    let accordionSlideInterval = null;

    function renderSlide() {
      const slides = tabData[currentTab] || [];
      if (!slides.length) {
        middleContent.innerHTML = `<h3 class="text-xl font-semibold text-white">No slides available</h3>`;
        rightImage.src = '';
        return;
      }
      if (currentSlide >= slides.length) currentSlide = 0;
      const slide = slides[currentSlide];
      middleContent.innerHTML = `
        <span class="bg-gray-400 text-white px-3 py-1 text-xs rounded mb-4 uppercase">${slide.tag || ''}</span>
        <h3 class="text-2xl font-bold mb-4">${slide.title || ''}</h3>
        <a href="#" class="text-white font-semibold inline-flex items-center">Learn More <span class="ml-2">→</span></a>
        <div class="flex space-x-2 mt-6">
          ${slides.map((_, i) => `<div class="w-3 h-3 rounded-full ${i === currentSlide ? 'bg-white' : 'bg-white/50'}"></div>`).join('')}
        </div>
      `;
      rightImage.src = slide.img || '';
    }

    function startAutoSlide() {
      clearInterval(autoSlideInterval);
      autoSlideInterval = setInterval(() => {
        const slides = tabData[currentTab] || [];
        if (!slides.length) return;
        currentSlide = (currentSlide + 1) % slides.length;
        renderSlide();
      }, 4000);
    }

    // tabs click handle desktop
    tabButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        if (window.innerWidth > 768) {
          tabButtons.forEach(t => t.classList.remove('active-tab'));
          tabButtons.forEach(t => t.classList.add('inactive-tab'));
          btn.classList.add('active-tab');
          btn.classList.remove('inactive-tab');

          currentTab = btn.dataset.tab;
          currentSlide = 0;
          renderSlide();
          startAutoSlide();

          // Close any open accordion on desktop
          document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('active'));
          document.querySelectorAll('.toggle-icon').forEach(ic => ic.src = '<?= base_url('files/images/plus-01.svg') ?>');
          if (accordionSlideInterval) {
            clearInterval(accordionSlideInterval);
            accordionSlideInterval = null;
          }
        }
      });
    });
    renderSlide();
    startAutoSlide();

    // Mobile accordion toggle
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          const tabId = this.dataset.tab;
          const content = document.getElementById('accordion-' + tabId);
          const icon = this.querySelector('.toggle-icon');
          const isActive = content.classList.contains('active');
          document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('active'));
          document.querySelectorAll('.toggle-icon').forEach(ic => ic.src = '<?= base_url('files/images/plus-01.svg') ?>');

          if (window.accordionSlideInterval) {
            clearInterval(window.accordionSlideInterval);
            window.accordionSlideInterval = null;
          }

          if (!isActive) {
            content.classList.add('active');
            icon.src = '<?= base_url('files/images/minus-01.svg') ?>';

            const slides = tabData[tabId] || [];
            if (slides.length === 0) {
              content.innerHTML = '<p class="p-4 text-white">No slides available</p>';
              return;
            }

            let accordionCurrentSlide = 0;

            function renderAccordionSlide() {
              const slide = slides[accordionCurrentSlide];
              content.innerHTML = `
                <div class="bg-black/40 p-4 rounded text-white" style="
                  background-image: url('${slide.img}');
                  background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                  min-height: 200px;
                  ">
                  <span class="bg-gray-400 text-white px-3 py-1 text-xs rounded mb-4 uppercase inline-block">${slide.tag || ''}</span>
                  <h3 class="text-lg font-bold mb-2">${slide.title || ''}</h3>
                  <a href="#" class="text-white font-semibold inline-flex items-center">Learn More <span class="ml-2">→</span></a>
                </div>
                <div class="flex space-x-2 mt-2 justify-center">
                  ${slides.map((_, i) => `<div class="w-3 h-3 rounded-full ${i === accordionCurrentSlide ? 'bg-blue-400' : 'bg-white/50'}"></div>`).join('')}
                </div>
              `;
            }

            renderAccordionSlide();

            window.accordionSlideInterval = setInterval(() => {
              accordionCurrentSlide = (accordionCurrentSlide + 1) % slides.length;
              renderAccordionSlide();
            }, 4000);

          } else {
            content.classList.remove('active');
            icon.src = '<?= base_url('files/images/plus-01.svg') ?>';
          }
        }
      });
    });
  </script>

</body>
</html>
