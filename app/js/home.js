const updateGamesList = (gamesWrapper, data) => {
	// clear already existing games
	Array.from(gamesWrapper.children).forEach(game => game.remove());
	
	// loop through each game
	data.sort((a, b) => Number(b["streams"]) - Number(a["streams"]))
		.forEach(game => {
			const wrapper = document.createElement("div");
			gamesWrapper.appendChild(wrapper);
			const gameInfo = document.createElement("ul");
			wrapper.appendChild(gameInfo);
			gameInfo.classList.add("game");
			
			const gameCoverWrapper = document.createElement("li");
			gameInfo.appendChild(gameCoverWrapper);
			const link = document.createElement("a");
			gameCoverWrapper.appendChild(link);
			link.href = "game?id="+game["id"];
			const gameCover = document.createElement("img");
			link.appendChild(gameCover);
			gameCover.src = game["cover"];
			
			const gameNameWrapper = document.createElement("li");
			gameInfo.appendChild(gameNameWrapper);
			const gameName = document.createElement("div");
			gameNameWrapper.appendChild(gameName);
			gameName.appendChild(document.createTextNode(game["name"]));
			const gameStreams = document.createElement("div");
			gameNameWrapper.appendChild(gameStreams);
			gameStreams.appendChild(document.createTextNode((game["streams"] +" events")));
			const gameStar = document.createElement("img");
			gameNameWrapper.appendChild(gameStar);
			if (userFavoriteGames.includes(game["id"])) {
				gameStar.src = "images/star-filled.png";
				gameStar.classList.add("favorited");
				gameStar.title = "Remove game from Favorites!";
			}
			else {
				gameStar.src = "images/star.png";
				gameStar.title = "Favorite game!";
			}
			gameStar.addEventListener("click", () => {
				if (gameStar.classList.contains("favorited")) {
					postRequest("api/users?mode=favorite&action=delete", {
						"userId": userSession["userId"],
						"gameId": game["id"]
					});
					gameStar.src = "images/star.png";
					gameStar.classList.remove("favorited");
					userFavoriteGames = userFavoriteGames.filter(gameId => Number(gameId) != game["id"]);
				}
				else {
					console.log(userSession["userId"], game["id"]);
					postRequest("api/users?mode=favorite&action=add", {
						"userId": userSession["userId"],
						"gameId": game["id"]
					});
					gameStar.src = "images/star-filled.png";
					gameStar.classList.add("favorited");
					userFavoriteGames.push(game["id"]);
				}
			});
			gameStar.addEventListener("mouseover", () => {
				if (!gameStar.classList.contains("favorited")) gameStar.src = "images/star-filled.png";
			});
			gameStar.addEventListener("mouseout", () => {
				if (!gameStar.classList.contains("favorited")) gameStar.src = "images/star.png";
			});
			
			gameCoverWrapper.addEventListener("mouseover", e => {
				gameCoverWrapper.style.filter = "opacity(0.7)";
				gameCover.style.transform = "scale(1.05)";
			});
					
			gameCoverWrapper.addEventListener("mouseout", e => {
				gameCoverWrapper.style.removeProperty("filter");
				gameCover.style.removeProperty("transform");
			});
		});
		
		// if no games found
		if (data.length == 0) {
			const noGames = document.createElement("p");
			gamesWrapper.appendChild(noGames);
			noGames.appendChild(document.createTextNode("No games found!"));
		}

		// wait until all game covers are loaded
		Promise.all(Array.from(gamesWrapper.getElementsByTagName("img"))
				.filter(img => !img.complete)
				.map(img => new Promise(resolve => { img.onload = img.onerror = resolve; })))
			.then(() => {
				const loading = document.getElementsByClassName("loading-cover")[0];
				if (loading) loading.remove();
				gamesWrapper.style.removeProperty("display");
			});
}

// number of games
let nGames = 0;
const input = document.getElementsByClassName("input-field")[0];

const searchGames = endpoint => {
	fetch(endpoint)
		.then(response => response.json())
		.then(data => {
			nGames = data["size"];
			const gamesTitle = document.getElementById("n-games");
			if (gamesTitle) {
				gamesTitle.innerHTML = `Games (${nGames})`;
			}
			data = data["data"];
			
			const gamesWrapper = document.getElementsByClassName("games-list")[0];
			if (gamesWrapper) {
				updateGamesList(gamesWrapper, data);
			}
		});
}

const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('q')) {
	if (input) {
  		input.value = urlParams.get('q');
  		searchGames("api/games?name="+input.value);
	}
}
else if (window.location.hash == "#favorites") {
	const favorites = document.getElementById("favorites-filter");
	if (favorites) setTimeout(() => favorites.click(), 50);
}
else {
	searchGames("api/games");
}	

if (window.location.hash == "#cart") {
	const ticketButton = document.getElementsByClassName("ticket-button")[0];
	console.log(ticketButton);
	if (ticketButton) setTimeout(() => ticketButton.click(), 50);
}

if (input) {
	input.addEventListener("input", e => {
		const value = e.target.value;
		insertUrlParam("q", value);
		searchGames("api/games?name="+value);
	}); 
}

const favorites = document.getElementById("favorites-filter");
if (favorites) {
	favorites.addEventListener("click", () => {
		if (!favorites.classList.contains("favorited")) {
			window.location.hash = "favorites";
			searchGames("api/games?id="+userFavoriteGames.join(","));
			favorites.classList.add("favorited");
			favorites.src = "images/star-filled.png";
			document.title = "Favorite Games - Gamebet";
		}
		else {
			history.replaceState(null, null, ' ');
			if (input)
				searchGames("api/games?name="+input.value);
			else
				searchGames("api/games");
			favorites.classList.remove("favorited");
			favorites.src = "images/star.png";
			document.title = "Games - Gamebet";
		}
	});
	favorites.addEventListener("mouseover", () => {
		if (!favorites.classList.contains("favorited")) favorites.src = "images/star-filled.png";
	});
	favorites.addEventListener("mouseout", () => {
		if (!favorites.classList.contains("favorited")) favorites.src = "images/star.png";
	});
}
