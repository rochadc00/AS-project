fetch("api/registered?userId="+userSession["userId"])
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const ticketsWrapper = document.createElement("div");
        document.body.appendChild(ticketsWrapper);

        const tickets = data["data"];
        let n = tickets.length;
        tickets.sort((a,b) => new Date(b["date"]) - new Date(a["date"]))
            .forEach(ticket => {
                const ticketWrapper = document.createElement("div");
                ticketsWrapper.appendChild(ticketWrapper);
                ticketWrapper.classList.add("ticket-row");
                const ticketTitle = document.createElement("div");
                ticketWrapper.appendChild(ticketTitle);
                ticketTitle.appendChild(document.createTextNode(`Ticket ${n--}: ${ticket["ticketType"]} - ${ticket["date"]}`));
                const betsWrapper = document.createElement("div");
                ticketWrapper.appendChild(betsWrapper);
                fetch("api/bets?id="+ticket["bets"].join(","))
                    .then(response => response.json())
                    .then(bets => bets["data"].forEach(bet => {
                        const betContainer = ticketBet(bet, ticket["ticketType"]);
                        betsWrapper.appendChild(betContainer);
                        betContainer.style.margin = "5px 20px";
                        // remove bin
                        betContainer.children[1].remove();
                    }));
                const ticketInfo = document.createElement("div");
                ticketWrapper.appendChild(ticketInfo);
                const tags = ["Bets", "Odds", "Value", "Possible Wins"];
                [ticket["bets"].length, ticket["odds"], ticket["ticketValue"], ticket["wins"]].forEach((tag, i) => {
                    const tagWrapper = document.createElement("div");
                    ticketInfo.appendChild(tagWrapper);
                    const tagValue = document.createElement("b");
                    tagWrapper.appendChild(tagValue);
                    tagValue.appendChild(document.createTextNode(tags[i]+": "));
                    tagWrapper.appendChild(document.createTextNode(tag));
                });
            });
    }); 