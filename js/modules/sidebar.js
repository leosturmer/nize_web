export function inicializarSidebar() {
  const resizeBtn = document.querySelector("[data-resize-btn]");
  const icon = resizeBtn.querySelector("i");

  const alternarIcone = () => {
    const ativo = document.body.classList.contains("sb-expanded");
    icon.classList.toggle("bi-x-lg", ativo);
    icon.classList.toggle("bi-list", !ativo);
  };

  resizeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    document.body.classList.toggle("sb-expanded");
    alternarIcone();
  });

  resizeBtn.addEventListener("mouseenter", alternarIcone);
  resizeBtn.addEventListener("mouseleave", alternarIcone);
}

export function inicializarHeaderMobile() {
  const resizeBtn = document.querySelector("[data-resize-btn-mobile]");
  const icon = resizeBtn.querySelector("i");

  const alternarIcone = () => {
    const ativo = document.body.classList.contains("sb-expanded");
    icon.classList.toggle("bi-x-lg", ativo);
    icon.classList.toggle("bi-list", !ativo);
  };

  resizeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    document.body.classList.toggle("sb-expanded");
    alternarIcone();
  });

  resizeBtn.addEventListener("mouseenter", alternarIcone);
  resizeBtn.addEventListener("mouseleave", alternarIcone);
}
