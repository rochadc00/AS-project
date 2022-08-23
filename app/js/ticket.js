let ticketData = {};
let lastInputValue = "";

let lowerContainer, betsContainer;
const updateBetsContainerHeight = () => {
	if (lowerContainer && betsContainer) {
		setTimeout(() => betsContainer.style.height = (window.innerHeight-betsContainer.offsetTop-lowerContainer.offsetHeight-90)+"px", 50);
	}
}

const updateBetsWidth = windowWidth => {
	if (windowWidth <= 680 && windowWidth >= 410)
		document.documentElement.style.setProperty('--bet-width', (windowWidth-110)+"px");
	else if (windowWidth < 410)
				document.documentElement.style.setProperty('--bet-width', "unset");
	else
			document.documentElement.style.setProperty('--bet-width', "330px");
}

const ticketPopup = data => {
	window.location.hash = "#cart";
	
	const wrapper = document.createElement("div");
	wrapper.classList.add("ticket-popup", "ticket-popup-closed");

	// upper part
	const upperContainer = document.createElement("div");
	wrapper.appendChild(upperContainer);
	// close
	const closeWrapper = document.createElement("div");
	upperContainer.appendChild(closeWrapper);
	closeWrapper.classList.add("clickable");
	closeWrapper.addEventListener("click", () => {
		history.replaceState(null, null, ' ');
		wrapper.classList.add("ticket-popup-closed");
		setTimeout(() => wrapper.remove(), 500);
		// extend list of streams
		const streams = document.getElementById("streams");
		if (streams) document.body.classList.remove("shrinked-streams");
	});
	const close = document.createElement("div");
	closeWrapper.appendChild(close);
	const xBar1 = document.createElement("div");
	close.appendChild(xBar1);
	const xBar2 = document.createElement("div");
	close.appendChild(xBar2);
	// ticket title
	const ticketTitle = document.createElement("div");
	upperContainer.appendChild(ticketTitle);
	ticketTitle.appendChild(document.createTextNode(`Ticket (${data["bets"].length})`));
	// ticket type chooser
	const typeChooserWrapper = document.createElement("div");
	upperContainer.appendChild(typeChooserWrapper);
	const typeChooser = document.createElement("ul");
	typeChooserWrapper.appendChild(typeChooser);
	["Simple", "Multiple", "Group"].forEach(typeText => {
		const type = document.createElement("li");
		typeChooser.appendChild(type);
		type.appendChild(document.createTextNode(typeText));
		if (typeText == data["ticketType"]) type.style.backgroundColor = "var(--pink)";

		type.addEventListener("click", e => {

			fetch(`api/tickets?ticketType=${typeText}&userId=${userSession["userId"]}`)
				.then(response => response.json())
				.then(data => {
					const oldPopup = document.getElementsByClassName("ticket-popup")[0];
                    ticketData = data["data"][0];
					const popup = ticketPopup(ticketData);
					document.body.insertBefore(popup, oldPopup);
					popup.classList.remove("ticket-popup-closed");
					// remove old popup
					setTimeout(() => oldPopup.remove(), 50);   
				});
		});
	});

	betsContainer = document.createElement("div");
	if (data["bets"].length > 0) {
		// put all bets
		upperContainer.appendChild(betsContainer);
		fetch("api/bets?id="+data["bets"].join(","))
			.then(response => response.json())
			.then(betData => betData["data"].forEach(bet => betsContainer.appendChild(ticketBet(bet, data["ticketType"]))));
	}
	else {
		// no bets yet
		upperContainer.appendChild(betsContainer);
		betsContainer.classList.add("no-bets");
		betsContainer.appendChild(document.createTextNode("No bets yet!"));
	}

	// lower part
	lowerContainer = document.createElement("div");
	wrapper.appendChild(lowerContainer);
	// values
	const valuesWrapper = document.createElement("div");
	lowerContainer.appendChild(valuesWrapper);
	// values first layer
	const valuesFirstLayer = document.createElement("div");
	valuesWrapper.appendChild(valuesFirstLayer);
	const valuesOdds = document.createElement("div");
	valuesFirstLayer.appendChild(valuesOdds);
	valuesOdds.appendChild(document.createTextNode("Odds: "+data["odds"]));
	valuesOdds.id = "ticketOdds";
	const valuesPayWrapper = document.createElement("div");
	valuesFirstLayer.appendChild(valuesPayWrapper);
	valuesPayWrapper.classList.add("money-input");
	const valueInput = document.createElement("input");
	valuesPayWrapper.appendChild(valueInput);
	valueInput.type = "text";
	valueInput.value = data["ticketValue"];
	const currencyButton = document.createElement("div");
	valuesPayWrapper.appendChild(currencyButton);
	const valueCurrency = document.createElement("div");
	currencyButton.appendChild(valueCurrency);
	valueCurrency.appendChild(document.createTextNode("€"));
	const imgArrow = document.createElement("img");
	currencyButton.appendChild(imgArrow);
	imgArrow.src = "images/arrow.png";
	// values middle white space
	valuesWrapper.appendChild(document.createElement("div"));
	// values second layer
	const valuesSecondLayer = document.createElement("div");
	valuesWrapper.appendChild(valuesSecondLayer);
	const valuesPossibleWins = document.createElement("div");
	valuesSecondLayer.appendChild(valuesPossibleWins);
	valuesPossibleWins.appendChild(document.createTextNode("Possible Wins:"));
	const valuesWin = document.createElement("div");
	valuesSecondLayer.appendChild(valuesWin);
	ticketData["wins"] = (Number(data["ticketValue"])*Number(data["odds"])).toFixed(2);
	valuesWin.appendChild(document.createTextNode(ticketData["wins"]+"€"));
	// button
	const buttonWrapper = document.createElement("div");
	lowerContainer.appendChild(buttonWrapper);
	buttonWrapper.classList.add("clickable");
	console.log(ticketData);
	if ((!document.getElementById("ticketOdds") && Number(ticketData["odds"]) == 0) || (document.getElementById("ticketOdds") && Number(document.getElementById("ticketOdds")) == 0))
		buttonWrapper.classList.add("disabled");
	buttonWrapper.appendChild(document.createTextNode("BET NOW"));
	buttonWrapper.addEventListener("click", () => {
		if (document.getElementById("ticketOdds") && Number(document.getElementById("ticketOdds")) != 0) {
			// check if user has enough money
			console.log(valueInput.value);
			if (Number(userBalance["money"]) >= Number(valueInput.value)) {				
				// place ticket
				postRequest("api/tickets?mode=delete", {
					"id": userSession["userTickets"]["Multiple"]
				});

				const ticketNavbarCounter = document.getElementsByClassName("ticketNavbar-counter")[0];
				if (ticketNavbarCounter && ticketNavbarCounter.children[0]) {
					const child = ticketNavbarCounter.children[0];
					child.innerText = Number(child.innerText) + 1;
				}

				// register bet
				postRequest("api/tickets?mode=register", data);
				
				userBalance["money"] = Number(userBalance["money"]) - Number(valueInput.value);
				postRequest("api/users?mode=balance", userBalance);
				const navbarMoney = document.getElementById("navbar-money");
				if (navbarMoney) navbarMoney.innerHTML = userBalance["money"]+"€";

				setTimeout(() => {
					fetch(`api/tickets?ticketType=Multiple&userId=${userSession["userId"]}`)
					.then(response => response.json())
					.then(result => {
						const oldPopup = document.getElementsByClassName("ticket-popup")[0];
						const popup = ticketPopup(result["data"][0]);
						document.body.insertBefore(popup, oldPopup);
						popup.classList.remove("ticket-popup-closed");
						// remove old popup
						setTimeout(() => oldPopup.remove(), 50);
						// update number in ticket button
						updateTicketButton(0, true);
						
						// re activate all bet buttons
						Array.from(document.getElementsByClassName("bet-button-inactive")).forEach(button => button.classList.remove("bet-button-inactive"));
					
						console.log("Bets placed!",);
						// bets placed message
						betsPlacedMessage("Bets placed!", "#55d955");
					});
				}, 200);
			}
			else {
				console.log("Insuficient funds to register ticket!");
				betsPlacedMessage("Insuficient funds to register ticket! <a style='text-decoration: underline;' href='deposit'>DEPOSIT</a>", "red");
			}
		}
	});

    valueInput.addEventListener("input", () => {
    	valueInput.value = (!isNaN(valueInput.value) ? valueInput.value : lastInputValue).trim()
      	ticketData["ticketValue"] = valueInput.value;
		lastInputValue = ticketData["ticketValue"];

		postRequest("api/tickets?mode=update", ticketData);

		fetch("api/tickets?keys=odds&id="+userSession["userTickets"]["Multiple"])
		.then(response => response.json())
		.then(dataOdds => {
			ticketData["wins"] = Number(valueInput.value)*Number(dataOdds["data"][0]["odds"]);
			valuesWin.innerText = ticketData["wins"].toFixed(2)+"€";
			
			ticketData["odds"] = dataOdds["data"][0]["odds"];
			postRequest("api/tickets?mode=update", ticketData);
		});
    });

	updateBetsContainerHeight();
	updateBetsWidth(window.innerWidth);

	return wrapper;
}

const ticketBet = (data, ticketType) => {
	const wrapper = document.createElement("div");
	wrapper.classList.add("ticket-bet");
	
	//bet info
	const betInfo = document.createElement("div");
	wrapper.appendChild(betInfo);
	// upper info
	const upperInfo = document.createElement("div");
	betInfo.appendChild(upperInfo);
	const date = document.createElement("div");
	upperInfo.appendChild(date);
	date.appendChild(document.createTextNode(data["stream"]["matchBeginning"]));
	const game = document.createElement("div");
	upperInfo.appendChild(game);
	fetch("api/games?keys=name&id="+data["stream"]["gameId"])
		.then(response => response.json())
		.then(gameData => game.appendChild(document.createTextNode(gameData["data"][0]["name"])));
	// lower info
	const lowerInfo = document.createElement("div");
	betInfo.appendChild(lowerInfo);
	const teams = document.createElement("div");
	lowerInfo.appendChild(teams);
	teams.appendChild(document.createTextNode(`${data["stream"]["teamA"]} vs ${data["stream"]["teamB"]}`));
	const betTitle = document.createElement("div");
	lowerInfo.appendChild(betTitle);
	const bold = document.createElement("b");
	betTitle.appendChild(bold);
	bold.appendChild(document.createTextNode(data["resultType"]+":"));
	betTitle.appendChild(document.createTextNode(data["resultTeam"]));
	const odd = document.createElement("div");
	lowerInfo.appendChild(odd);
	odd.appendChild(document.createTextNode(data["odd"]));

	// bin
	const binWrapper = document.createElement("div");
	wrapper.appendChild(binWrapper);
	const bin = document.createElement("img");
	binWrapper.appendChild(bin);
	bin.src="images/bin.png";
	binWrapper.addEventListener("click", () => {
		postRequest("api/tickets?mode=decrease", {
			"betId": data["id"],
			"ticketId": userSession["userTickets"][ticketType]
		});

		fetch("api/tickets?keys=odds&id="+userSession["userTickets"]["Multiple"])
			.then(response => response.json())
			.then(dataOdds => {
				console.log(Number(dataOdds["data"][0]["odds"]), Number(data["odd"]));
				const newOddsValue = Number(dataOdds["data"][0]["odds"]) == Number(data["odd"]) ? 0 : Number(dataOdds["data"][0]["odds"]) / Number(data["odd"]);
				postRequest("api/tickets?mode=update", {
					"id": userSession["userTickets"]["Multiple"],
					"odds": newOddsValue.toFixed(2)
				});
				
				fetch(`api/tickets?ticketType=Multiple&userId=${userSession["userId"]}`)
					.then(response => response.json())
					.then(data => {
						const oldPopup = document.getElementsByClassName("ticket-popup")[0];
						const ticketData = data["data"][0];
						const popup = ticketPopup(ticketData);
						document.body.insertBefore(popup, oldPopup);
						popup.classList.remove("ticket-popup-closed");
						// remove old popup
						setTimeout(() => oldPopup.remove(), 50);
						// update number in ticket button
						updateTicketButton(-1, false);
					});
			});
			
			const betButtons = document.getElementsByClassName("bet-button-inactive");
			if (betButtons) {
				Array.from(betButtons).filter(bet => Number(bet.dataset.id) == data["id"])[0].classList.remove("bet-button-inactive");
			}
	});
	
	return wrapper;
}

const updateTicketButton = (value, fixed) => {
	console.log("a");
	const ticketButton = document.getElementsByClassName("ticket-button")[0];
	if (ticketButton) {
		console.log("b");
		const ticketButtonValue = ticketButton.getElementsByClassName("absolute-centered")[0];
		if (ticketButtonValue) {
			console.log("c");
			if (fixed) ticketButtonValue.innerText = value;
			else ticketButtonValue.innerText = Number(ticketButtonValue.innerText) + value;
		}
	}
}

const ticketButton = document.getElementsByClassName("ticket-button")[0];
if (ticketButton) {
	ticketButton.addEventListener("click", () => {
		fetch("api/tickets?ticketType=Multiple&userId="+userSession["userId"])
			.then(response => response.json())
			.then(data => {
                ticketData = data["data"][0];
				const popup = ticketPopup(ticketData);
				document.body.appendChild(popup);
				setTimeout(() => popup.classList.remove("ticket-popup-closed"), 50);

				const streams = document.getElementById("streams");
				if (streams) document.body.classList.add("shrinked-streams");
			});
	});
}

window.addEventListener("click", e => {
	const target = e.target;

	// click outside to close cart popup
	const ticketPopup = document.getElementsByClassName("ticket-popup")[0];
	if (ticketPopup && !target.closest(".ticket-popup") && !target.closest(".ticket-button") && window.getComputedStyle(target)["cursor"] !== "pointer") {
		history.replaceState(null, null, ' ');
		ticketPopup.classList.add("ticket-popup-closed");
		setTimeout(() => ticketPopup.remove(), 500);

		// extend list of streams
		const streams = document.getElementById("streams");
		if (streams) document.body.classList.remove("shrinked-streams");
	}
});

// update value on ticket button
fetch("api/tickets?keys=bets&id="+userSession["userTickets"]["Multiple"])
	.then(response => response.json())
	.then(data => updateTicketButton(data["data"][0]["bets"].length, true));
	
const betsPlacedMessage = (text, color) => {
	// bets placed message
	const message = document.createElement("div");
	const updatedWrapper = document.getElementsByClassName("ticket-popup")[0];
	if (updatedWrapper) {
		updatedWrapper.appendChild(message);
		message.classList.add("ticket-message");
		message.innerHTML = text;
		message.style.backgroundColor = color;
		setTimeout(() => {
			message.style.height = "260px";
			setTimeout(() => {
				message.style.height = "0";
				setTimeout(() => message.remove(), 500);
			}, 4000);
		}, 50);
	}
}

window.onresize = () => {
	updateBetsContainerHeight();
	updateBetsWidth(window.innerWidth);
}

window.addEventListener("swiped-left", e => {
	const popup = document.getElementsByClassName("ticket-popup")[0];
	if (!popup) {
	 	const ticketButton = document.getElementsByClassName("ticket-button")[0]
	    if (ticketButton) ticketButton.click();   
	}
});

	
window.addEventListener("swiped-right", e => {
	const popup = document.getElementsByClassName("ticket-popup")[0];
	if (popup) {
	    const closePopup = popup.getElementsByClassName("clickable")[0];
	    closePopup.click();
	}
});
