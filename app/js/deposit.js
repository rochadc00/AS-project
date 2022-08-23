const pay = document.getElementById("pay");
if (pay) {
	pay.addEventListener("click", () => {
		if (pay.dataset.value) {
			fetch("api/users?keys=money&id="+userSession["userId"])
				.then(response => response.json())
				.then(data => {
					postRequest("api/users?mode=balance", {
						"id": userSession["userId"],
						"money": Number(data["data"][0]["money"])+Number(pay.dataset.value)
					}, setTimeout(() => window.location.reload(), 200));
				});
		}
	});
}

const depositValues = document.getElementsByClassName("deposit-values")[0];
if (depositValues) {
	Array.from(depositValues.getElementsByTagName("button")).forEach(deposit => {
		deposit.addEventListener("click", () => {

			if (pay && !deposit.classList.contains("deposit-values-selected")) {
				pay.dataset.value = deposit.innerText.replaceAll("€", "");
				Array.from(document.getElementsByClassName("deposit-values-selected")).forEach(deposit => deposit.classList.remove("deposit-values-selected"));	
				deposit.classList.add("deposit-values-selected");
			}
			
			else if (deposit.classList.contains("deposit-values-selected")) {
				deposit.classList.remove("deposit-values-selected");
				pay.dataset.value = "";
			}

		});
	});
}

let lastInputValue = "";
const inputField = document.getElementsByClassName("input-field")[0].children[0];
if (inputField) {
	inputField.addEventListener("input", () => {
		Array.from(document.getElementsByClassName("deposit-values-selected")).forEach(deposit => deposit.classList.remove("deposit-values-selected"));	
		inputField.value = (!isNaN(inputField.value) ? inputField.value : lastInputValue).trim();
		pay.dataset.value = inputField.value;
		lastInputValue = inputField.value;
	});
}

const paymentPopup = (imgSrc, inputs, size) => {
	// clear all payment popups
	Array.from(document.getElementsByClassName("payment-popup")).forEach(popup => popup.parentElement.remove());

	const outerWrapper = document.createElement("div");
	outerWrapper.classList.add("absolute-centered");
	const wrapper = document.createElement("div");
	outerWrapper.appendChild(wrapper);
	wrapper.classList.add("payment-popup");
	wrapper.style.width = size[0]+"px";
	wrapper.style.height = size[1]+"px";
	const innerWrapper = document.createElement("div");
	wrapper.appendChild(innerWrapper);
	innerWrapper.classList.add("absolute-centered");
	const img = document.createElement("img");
	innerWrapper.appendChild(img);
	img.src = imgSrc;
	const depositValue = document.createElement("div");
	innerWrapper.appendChild(depositValue);
	const money = pay ? Number(pay.dataset.value) : 0;
	depositValue.appendChild(document.createTextNode("Deposit value: "+(money ? money : 0)+"€"));
	inputs.forEach(input => {
		const field = document.createElement("input");
		innerWrapper.appendChild(field);
		field.placeholder = input;
	});
	const save = document.createElement("div");
	save.appendChild(document.createTextNode("Save"));
	innerWrapper.appendChild(save);
	save.addEventListener("click", () => outerWrapper.remove());

	return outerWrapper;
}

window.addEventListener("click", e => {
	const target = e.target;
	if (target.closest(".image") && target.tagName == "IMG") {
		if (!target.classList.contains("image-clicked")) {
			Array.from(target.closest(".image").children).forEach(child => child.classList.remove("image-clicked"));
			target.classList.add("image-clicked");
			let inputs = [];
			let size = [];
			switch(target.src.split("/images/")[1]) {
				case "pagamento-mb.png":
					inputs = [];
					break;
				case "pagamento-mbway.png":
					inputs = ["Phone Number"];
					size = [400, 400];
					break;
				case "pagamento-visa.png":
					inputs = ["Name", "Card Number", "Expiration Date", "CVC"];
					size = [400, 600];
					break;
				case "pagamento-mastercard.png":
					inputs = ["Name", "Card Number", "Expiration Date", "CVC"];
					size = [400, 600];
					break;
			}
			document.body.appendChild(paymentPopup(target.src, inputs, size));
		}
		else
			target.classList.remove("image-clicked");
	}

	if (!target.closest(".image") && document.getElementsByClassName("payment-popup")[0] && !target.closest(".payment-popup")) {
		Array.from(document.getElementsByClassName("image")[0].children).forEach(child => child.classList.remove("image-clicked"));
		document.getElementsByClassName("payment-popup")[0].remove();
	}
});
