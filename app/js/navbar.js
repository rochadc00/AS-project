const balanceBoxes = document.getElementsByClassName("balance-box");
if (balanceBoxes) {
    Array.from(balanceBoxes).forEach(box => {
        const widthElem = box.children[0];
        const valueWidth = widthElem.children[0].offsetWidth;
        const plusWidth = box.children[1].offsetWidth;
        let imgWidth = 0;
        const img = box.getElementsByTagName("img")[0];
        if (img) imgWidth = img.offsetWidth + 5;
        widthElem.style.width = (valueWidth + plusWidth + imgWidth + 5)+"px";
    });
}

let userBalance = [];

fetch("api/users?keys=money,points&id="+userSession["userId"])
	.then(response => response.json())
	.then(data => {
		userBalance = data["data"][0]; 
	});

const sideNavbar = document.getElementsByClassName("side-navbar")[0];
const burgerMenu = document.getElementsByClassName("burger-menu")[0];
if (sideNavbar && burgerMenu) {
    burgerMenu.addEventListener("click", () => {
        if (burgerMenu.classList.contains("burger-menu-opened")) {
            sideNavbar.classList.add("side-navbar-hidden");
            burgerMenu.classList.remove("burger-menu-opened");
            setTimeout(() => sideNavbar.style.display = "none", 300);
        }
        else {
            sideNavbar.style.removeProperty("display");
            setTimeout(() => sideNavbar.classList.remove("side-navbar-hidden"), 100);
            burgerMenu.classList.add("burger-menu-opened");
        }
    });
}