function toNum(str) {
    return Number(String(str).replace(/\s/g, "").replace("₽", "").replace("руб.", "").replace(",", "."));
}

function toCurrency(num) {
    return new Intl.NumberFormat("ru-RU", {
        style: "currency",
        currency: "RUB",
        minimumFractionDigits: 0
    }).format(num);
}

class Cart {
    constructor() {
        this.products = [];
    }

    get count() {
        return this.products.reduce((acc, item) => acc + item.qty, 0);
    }

    get cost() {
        return this.products.reduce((acc, item) => acc + (item.price * item.qty), 0);
    }

    get discount() {
        if (this.cost >= 10000) {
            return Math.round(this.cost * 0.1);
        }
        return 0;
    }

    get costDiscount() {
        return this.cost - this.discount;
    }

    addProduct(product) {
        const existing = this.products.find(item => item.id === product.id);
        if (existing) {
            existing.qty += 1;
        } else {
            this.products.push({ ...product, qty: 1 });
        }
    }

    removeProduct(id) {
        const existing = this.products.find(item => item.id === id);

        if (!existing) return;

        if (existing.qty > 1) {
            existing.qty -= 1;
        } else {
            this.products = this.products.filter(item => item.id !== id);
        }
    }

    clearCart() {
        this.products = [];
    }
}

const myCart = new Cart();

if (localStorage.getItem("cityClassCart")) {
    myCart.products = JSON.parse(localStorage.getItem("cityClassCart"));
} else {
    localStorage.setItem("cityClassCart", JSON.stringify(myCart.products));
}

function saveCart() {
    localStorage.setItem("cityClassCart", JSON.stringify(myCart.products));
}

function updateCartCounter() {
    const cartNum = document.getElementById("cart_num");
    if (cartNum) {
        cartNum.textContent = myCart.count;
    }
}

function fillCartPopup() {
    const popupProductList = document.getElementById("popup_product_list");
    const popupCost = document.getElementById("popup_cost");
    const popupDiscount = document.getElementById("popup_discount");
    const popupCostDiscount = document.getElementById("popup_cost_discount");

    if (!popupProductList) return;

    popupProductList.innerHTML = "";

    if (myCart.products.length === 0) {
        popupProductList.innerHTML = '<p class="popup-empty">Корзина пуста</p>';
    } else {
        myCart.products.forEach(product => {
            const productItem = document.createElement("div");
            productItem.className = "popup__product";

            productItem.innerHTML = `
                <div class="popup__product-wrap">
                    <img src="${product.imageSrc}" alt="${product.name}" class="popup__product-image">
                    <div>
                        <h2 class="popup__product-title">${product.name}</h2>
                        <div class="popup__product-qty">Количество: ${product.qty}</div>
                    </div>
                </div>
                <div class="popup__product-wrap">
                    <div class="popup__product-price">${toCurrency(product.price * product.qty)}</div>
                    <button class="popup__product-delete" data-id="${product.id}">Удалить</button>
                </div>
            `;

            popupProductList.appendChild(productItem);
        });
    }

    popupCost.value = toCurrency(myCart.cost);
    popupDiscount.value = toCurrency(myCart.discount);
    popupCostDiscount.value = toCurrency(myCart.costDiscount);

    const deleteButtons = popupProductList.querySelectorAll(".popup__product-delete");
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const id = this.dataset.id;
            myCart.removeProduct(id);
            saveCart();
            updateCartCounter();
            fillCartPopup();
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const cart = document.getElementById("cart");
    const popup = document.querySelector(".popup");
    const popupClose = document.getElementById("popup_close");
    const body = document.body;
    const popupClear = document.getElementById("popup_clear");


    if (popupClear) {
        popupClear.addEventListener("click", function () {
            myCart.clearCart();
            saveCart();
            updateCartCounter();
            fillCartPopup();
        });
    }
    
    updateCartCounter();
    fillCartPopup();

    const addButtons = document.querySelectorAll("[data-cart-add]");
    addButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: Number(this.dataset.price),
                imageSrc: this.dataset.image
            };

            myCart.addProduct(product);
            saveCart();
            updateCartCounter();
            fillCartPopup();

            const cartBtn = document.getElementById("cart");
            if (cartBtn) {
                cartBtn.classList.add("cart--pulse");
                setTimeout(() => cartBtn.classList.remove("cart--pulse"), 400);
            }
        });
    });

    if (cart && popup) {
        cart.addEventListener("click", function (e) {
            e.preventDefault();
            fillCartPopup();
            popup.classList.add("popup--open");
            body.classList.add("lock");
        });
    }

    if (popupClose && popup) {
        popupClose.addEventListener("click", function (e) {
            e.preventDefault();
            popup.classList.remove("popup--open");
            body.classList.remove("lock");
        });
    }

    if (popup) {
        popup.addEventListener("click", function (e) {
            if (e.target === popup) {
                popup.classList.remove("popup--open");
                body.classList.remove("lock");
            }
        });
    }
});
const cartButton = document.getElementById("cart");

if (cartButton) {
    const savedCartPosition = localStorage.getItem("cityClassCartPosition");

    if (savedCartPosition) {
        const pos = JSON.parse(savedCartPosition);
        cartButton.style.top = pos.top + "px";
        cartButton.style.left = pos.left + "px";
        cartButton.style.right = "auto";
    }

    let isDragging = false;
    let hasMoved = false;
    let suppressClick = false;
    let startX = 0;
    let startY = 0;
    let offsetX = 0;
    let offsetY = 0;

    cartButton.addEventListener("mousedown", function (e) {
        isDragging = true;
        hasMoved = false;

        startX = e.clientX;
        startY = e.clientY;

        offsetX = e.clientX - cartButton.getBoundingClientRect().left;
        offsetY = e.clientY - cartButton.getBoundingClientRect().top;

        cartButton.style.cursor = "grabbing";
        e.preventDefault();
    });

    document.addEventListener("mousemove", function (e) {
        if (!isDragging) return;

        const dx = Math.abs(e.clientX - startX);
        const dy = Math.abs(e.clientY - startY);

        if (dx > 5 || dy > 5) {
            hasMoved = true;
        }

        if (!hasMoved) return;

        let left = e.clientX - offsetX;
        let top = e.clientY - offsetY;

        const maxLeft = window.innerWidth - cartButton.offsetWidth;
        const maxTop = window.innerHeight - cartButton.offsetHeight;

        if (left < 0) left = 0;
        if (top < 0) top = 0;
        if (left > maxLeft) left = maxLeft;
        if (top > maxTop) top = maxTop;

        cartButton.style.left = left + "px";
        cartButton.style.top = top + "px";
        cartButton.style.right = "auto";
    });

    document.addEventListener("mouseup", function () {
        if (!isDragging) return;

        isDragging = false;
        cartButton.style.cursor = "pointer";

        if (hasMoved) {
            suppressClick = true;

            localStorage.setItem("cityClassCartPosition", JSON.stringify({
                left: cartButton.offsetLeft,
                top: cartButton.offsetTop
            }));

            setTimeout(() => {
                suppressClick = false;
            }, 50);
        }
    });

    cartButton.addEventListener("click", function (e) {
        if (suppressClick) {
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        }
    }, true);
}