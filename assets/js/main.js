const products = [
  {
    id: 1,
    name: "Mai vàng cổ thụ 12 năm",
    category: "Cổ thụ",
    price: 18000000,
    height: 1.8,
    age: 12,
    trunk: 28,
    stock: 4,
    description: "Dáng cổ thụ với bộ rễ nổi, phù hợp không gian đại sảnh.",
    image: "assets/images/product-1.svg",
  },
  {
    id: 2,
    name: "Mai ghép dáng thác",
    category: "Dáng nghệ thuật",
    price: 12500000,
    height: 1.2,
    age: 8,
    trunk: 20,
    stock: 6,
    description: "Dáng thác đổ mềm mại, nụ dày, dễ chăm sóc.",
    image: "assets/images/product-2.svg",
  },
  {
    id: 3,
    name: "Mai mini để bàn",
    category: "Mini",
    price: 1800000,
    height: 0.4,
    age: 3,
    trunk: 8,
    stock: 20,
    description: "Gọn nhẹ, phù hợp trang trí bàn làm việc.",
    image: "assets/images/product-3.svg",
  },
  {
    id: 4,
    name: "Mai đại lộc uốn mây",
    category: "Bonsai",
    price: 22500000,
    height: 1.4,
    age: 15,
    trunk: 32,
    stock: 3,
    description: "Thế mây uyển chuyển, dáng nghệ thuật cao cấp.",
    image: "assets/images/product-4.svg",
  },
  {
    id: 5,
    name: "Mai vàng trung niên",
    category: "Trưng tết",
    price: 7800000,
    height: 1.1,
    age: 6,
    trunk: 16,
    stock: 10,
    description: "Dáng thẳng, tán tròn, phù hợp trưng bày tại gia.",
    image: "assets/images/product-5.svg",
  },
  {
    id: 6,
    name: "Mai ngũ phúc",
    category: "Độc bản",
    price: 35000000,
    height: 1.6,
    age: 18,
    trunk: 35,
    stock: 2,
    description: "Giống quý hiếm, nụ đều, sắc vàng đậm.",
    image: "assets/images/product-6.svg",
  },
];

const newsItems = [
  {
    id: 1,
    title: "Xu hướng mai vàng 2024",
    category: "Xu hướng",
    date: "12/02/2024",
    excerpt: "Những dáng mai được ưa chuộng và cách chăm sóc đúng chuẩn.",
  },
  {
    id: 2,
    title: "Bí quyết dưỡng nụ trước Tết",
    category: "Chăm sóc",
    date: "21/01/2024",
    excerpt: "Lịch tưới, bón phân và kiểm soát nhiệt độ cho mai nở đúng thời điểm.",
  },
  {
    id: 3,
    title: "Mai vàng miền Tây - câu chuyện làng nghề",
    category: "Cộng đồng",
    date: "05/01/2024",
    excerpt: "Ghé thăm làng nghề và quy trình tuyển chọn cây mai chất lượng.",
  },
  {
    id: 4,
    title: "Giải pháp trang trí lễ hội",
    category: "Dịch vụ",
    date: "18/12/2023",
    excerpt: "Kết hợp mai vàng với sân khấu, sảnh lễ tân, văn phòng.",
  },
  {
    id: 5,
    title: "Cập nhật bảng giá thuê mai",
    category: "Bảng giá",
    date: "01/12/2023",
    excerpt: "Bảng giá mới và các gói chăm sóc định kỳ cho doanh nghiệp.",
  },
  {
    id: 6,
    title: "Tư vấn tạo dáng bonsai",
    category: "Kỹ thuật",
    date: "18/11/2023",
    excerpt: "Các kỹ thuật uốn dây, tạo thế giúp mai phát triển bền vững.",
  },
];

const currencyFormatter = new Intl.NumberFormat("vi-VN", {
  style: "currency",
  currency: "VND",
  maximumFractionDigits: 0,
});

const initMobileMenu = () => {
  const toggle = document.querySelector(".mobile-toggle");
  const links = document.querySelector(".nav-links");
  if (!toggle || !links) return;
  toggle.addEventListener("click", () => links.classList.toggle("open"));
};

const renderList = (items, container, itemRenderer, paginationContainer, pageSize = 3) => {
  if (!container || !paginationContainer) return;
  let currentPage = 1;

  const renderPage = () => {
    const start = (currentPage - 1) * pageSize;
    const pageItems = items.slice(start, start + pageSize);
    container.innerHTML = pageItems.map(itemRenderer).join("");
    paginationContainer.innerHTML = Array.from({ length: Math.ceil(items.length / pageSize) }, (_, index) => {
      const page = index + 1;
      return `<button data-page="${page}" ${page === currentPage ? "class=\"active\"" : ""}>${page}</button>`;
    }).join("");
  };

  paginationContainer.addEventListener("click", (event) => {
    const page = event.target.getAttribute("data-page");
    if (page) {
      currentPage = Number(page);
      renderPage();
    }
  });

  renderPage();
};

const initProductSection = () => {
  const container = document.querySelector("#product-list");
  const pagination = document.querySelector("#product-pagination");
  const searchInput = document.querySelector("#product-search");
  if (!container || !pagination) return;

  const renderProducts = (data) => {
    renderList(
      data,
      container,
      (item) => `
        <div class="card">
          <a href="product-detail.html?id=${item.id}">
            <img src="${item.image}" alt="${item.name}" loading="lazy" />
          </a>
          <h3><a href="product-detail.html?id=${item.id}">${item.name}</a></h3>
          <span class="badge">${item.category}</span>
          <p>Tuổi cây: ${item.age} năm · Cao ${item.height}m</p>
          <strong>${currencyFormatter.format(item.price)}</strong>
        </div>
      `,
      pagination,
      3
    );
  };

  renderProducts(products);

  if (searchInput) {
    searchInput.addEventListener("input", (event) => {
      const query = event.target.value.toLowerCase();
      const filtered = products.filter((product) =>
        product.name.toLowerCase().includes(query) || product.category.toLowerCase().includes(query)
      );
      renderProducts(filtered);
    });
  }
};

const initNewsSection = () => {
  const container = document.querySelector("#news-list");
  const pagination = document.querySelector("#news-pagination");
  const searchInput = document.querySelector("#news-search");
  if (!container || !pagination) return;

  const renderNews = (data) => {
    renderList(
      data,
      container,
      (item) => `
        <div class="card">
          <span class="tag">${item.category}</span>
          <h3><a href="news-detail.html?id=${item.id}">${item.title}</a></h3>
          <p>${item.excerpt}</p>
          <small>${item.date}</small>
        </div>
      `,
      pagination,
      3
    );
  };

  renderNews(newsItems);

  if (searchInput) {
    searchInput.addEventListener("input", (event) => {
      const query = event.target.value.toLowerCase();
      const filtered = newsItems.filter((item) =>
        item.title.toLowerCase().includes(query) || item.category.toLowerCase().includes(query)
      );
      renderNews(filtered);
    });
  }
};

const initProductDetail = () => {
  const container = document.querySelector("#product-detail");
  if (!container) return;
  const params = new URLSearchParams(window.location.search);
  const id = Number(params.get("id"));
  const product = products.find((item) => item.id === id);
  if (!product) {
    container.innerHTML = "<p>Không tìm thấy sản phẩm phù hợp.</p>";
    return;
  }

  container.innerHTML = `
    <div class="detail-grid">
      <div class="card">
        <img src="${product.image}" alt="${product.name}" />
      </div>
      <div class="card">
        <span class="tag">${product.category}</span>
        <h2>${product.name}</h2>
        <p>${product.description}</p>
        <ul class="meta-list">
          <li>Tuổi cây: <strong>${product.age} năm</strong></li>
          <li>Chiều cao: <strong>${product.height}m</strong></li>
          <li>Vòng thân: <strong>${product.trunk}cm</strong></li>
          <li>Kho hiện tại: <strong>${product.stock} cây</strong></li>
        </ul>
        <h3>${currencyFormatter.format(product.price)}</h3>
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
          <a class="button" href="cart.html">Thêm vào giỏ</a>
          <a class="button outline" href="contact.html">Tư vấn ngay</a>
        </div>
      </div>
    </div>
  `;
};

const initNewsDetail = () => {
  const container = document.querySelector("#news-detail");
  if (!container) return;
  const params = new URLSearchParams(window.location.search);
  const id = Number(params.get("id"));
  const article = newsItems.find((item) => item.id === id);
  if (!article) {
    container.innerHTML = "<p>Không tìm thấy bài viết.</p>";
    return;
  }

  container.innerHTML = `
    <div class="card">
      <span class="tag">${article.category}</span>
      <h2>${article.title}</h2>
      <p><em>${article.date}</em></p>
      <p>${article.excerpt}</p>
      <p>Nội dung chi tiết đang được biên tập, vui lòng liên hệ để nhận thông tin đầy đủ.</p>
    </div>
  `;
};

const initPrediction = () => {
  const form = document.querySelector("#prediction-form");
  if (!form) return;
  const output = document.querySelector("#prediction-result");

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const age = Number(formData.get("age"));
    const height = Number(formData.get("height"));
    const trunk = Number(formData.get("trunk"));
    const variety = formData.get("variety");
    const maintenance = formData.get("maintenance");

    const varietyMultiplier = {
      co_thu: 1.4,
      bonsai: 1.3,
      thuong_mai: 1.0,
      mini: 0.7,
    };

    const maintenanceMultiplier = maintenance === "chuyen_sau" ? 1.2 : 1.0;

    const base = 1200000;
    const score = base + age * 450000 + height * 2800000 + trunk * 150000;
    const price = score * (varietyMultiplier[variety] || 1) * maintenanceMultiplier;

    if (output) {
      output.textContent = `Giá dự đoán: ${currencyFormatter.format(Math.round(price))}`;
    }
  });
};

const initDragDrop = () => {
  const dropZone = document.querySelector("#drop-zone");
  const fileInput = document.querySelector("#file-input");
  const output = document.querySelector("#drop-result");
  if (!dropZone || !fileInput) return;

  const updateOutput = (files) => {
    if (!output) return;
    output.textContent = `${files.length} tệp đã chọn: ${Array.from(files)
      .map((file) => file.name)
      .join(", ")}`;
  };

  dropZone.addEventListener("dragover", (event) => {
    event.preventDefault();
    dropZone.classList.add("dragover");
  });

  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("dragover");
  });

  dropZone.addEventListener("drop", (event) => {
    event.preventDefault();
    dropZone.classList.remove("dragover");
    const files = event.dataTransfer.files;
    fileInput.files = files;
    updateOutput(files);
  });

  fileInput.addEventListener("change", (event) => updateOutput(event.target.files));
};

const initValidation = () => {
  document.querySelectorAll("form[data-validate]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          field.style.borderColor = "#e35d5d";
          isValid = false;
        } else {
          field.style.borderColor = "#d6ded9";
        }
      });

      if (!isValid) {
        event.preventDefault();
        alert("Vui lòng điền đầy đủ thông tin bắt buộc.");
      }
    });
  });
};

const initQuill = () => {
  const editor = document.querySelector("#editor");
  if (!editor || typeof Quill === "undefined") return;
  new Quill("#editor", {
    theme: "snow",
    placeholder: "Soạn nội dung tin tức hoặc thông báo...",
  });
};

const initSwiper = () => {
  if (typeof Swiper === "undefined") return;
  const swiperEl = document.querySelector(".swiper");
  if (!swiperEl) return;
  new Swiper(swiperEl, {
    loop: true,
    autoplay: { delay: 4000 },
    pagination: { el: ".swiper-pagination", clickable: true },
  });
};

const initLazyAnimations = () => {
  const animatedItems = document.querySelectorAll("[data-animate]");
  if (!animatedItems.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );

  animatedItems.forEach((item) => observer.observe(item));
};

const init = () => {
  initMobileMenu();
  initProductSection();
  initNewsSection();
  initPrediction();
  initDragDrop();
  initValidation();
  initQuill();
  initSwiper();
  initLazyAnimations();
  initProductDetail();
  initNewsDetail();
};

document.addEventListener("DOMContentLoaded", init);
