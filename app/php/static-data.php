<?php

// usernames fetched from https://jimpix.co.uk/words/random-username-generator.asp
$usernames = array(
    "AlienatedMussel",
    "NeedlessTermite",
    "ObsoleteAuk",
    "IdealCobra",
    "PhonyMagpie",
    "VulnerableCrocodile",
    "OurVole",
    "PaternalThrushe",
    "FeignedBison",
    "DidacticBongo",
    "AblePorcupine",
    "GleamingSeahorse",
    "DraftyOxbird",
    "WonderfulRat",
    "DiligentRoedeer",
    "PolishedRhino",
    "ClassyMoth",
    "IndolentBaboon",
    "WorstMinnow",
    "UnguardedPelican",
    "UpbeatHawk",
    "ThirstyCow",
    "ObsceneHedgehog",
    "FumblingCod",
    "JoblessLlama",
    "EvasiveGuillemot",
    "RespectfulDingo",
    "HypnoticCamel",
    "StingyWalrus",
    "SomeBlackfish",
    "AxiomaticPig",
    "SecondhandJay",
    "SuperbDunbird",
    "WorthwhileCurlew",
    "PopularCrane",
    "WeightyGoldfinch",
    "GuiltlessIbexe",
    "ChildishPeafowl",
    "RotatingGull",
    "ProbableWoodcock",
    "UltimatePython",
    "SuburbanSwan",
    "TastyHeron",
    "UnpleasantWildebeest",
    "ThunderousCormorant",
    "TrainedWildcat",
    "OutlyingBoa",
    "PassiveViper",
    "MuddledShads",
    "EndurableColobus"
);

// games and cover fetched from https://www.twitch.tv/directory
$games = array(
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/32399_IGDB-285x380.jpg",
        "Counter-Strike: Global Offensive"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/21779-285x380.jpg",
        "League of Legends"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/32982_IGDB-285x380.jpg",
        "Grand Theft Auto V"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/516575-285x380.jpg",
        "VALORANT"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/511224-285x380.jpg",
        "Apex Legends"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/1869092879_IGDB-285x380.jpg",
        "FIFA 22"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/33214-285x380.jpg",
        "Fortnite"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/29595-285x380.jpg",
        "Dota 2"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/27471_IGDB-285x380.jpg",
        "Minecraft"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/512710-285x380.jpg",
        "Call of Duty: Warzone"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/18122-285x380.jpg",
        "World of Warcraft"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/491487-285x380.jpg",
        "Dead by Daylight"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/30921-285x380.jpg",
        "Rocket League"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/2044170173_IGDB-285x380.jpg",
        "Nintendo Switch Sports"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/138585_IGDB-285x380.jpg",
        "Hearthstone"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/513181-285x380.jpg",
        "Genshin Impact"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/766548668_IGDB-285x380.jpg",
        "V Rising"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/65632_IGDB-285x380.jpg",
        "DayZ"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/29307_IGDB-285x380.jpg",
        "Path of Exile"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/512953_IGDB-285x380.jpg",
        "Elden Ring"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/513143-285x380.jpg",
        "Teamfight Tactics"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/510150_IGDB-285x380.jpg",
        "Diablo Immortal"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/493057-285x380.jpg",
        "PUBG: BATTLEGROUNDS"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/491931_IGDB-285x380.jpg",
        "Escape from Tarkov"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/490100-285x380.jpg",
        "Lost Ark"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/27546-285x380.jpg",
        "World of Tanks"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/497057-285x380.jpg",
        "Destiny 2"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/488552-285x380.jpg",
        "Overwatch"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/490377-285x380.jpg",
        "Sea of Thieves"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/514888_IGDB-285x380.jpg",
        "Crusader Kings III"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/488190-285x380.jpg",
        "Poker"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/497480_IGDB-285x380.jpg",
        "Detroit: Become Human"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/491080-285x380.jpg",
        "The Binding of Isaac: Repentance"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/391992674_IGDB-285x380.jpg",
        "Leap"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/490422-285x380.jpg",
        "StarCraft II"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/2692_IGDB-285x380.jpg",
        "Super Mario 64"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/32507-285x380.jpg",
        "SMITE"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/512980-285x380.jpg",
        "Fall Guys: Ultimate Knockout"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/8645_IGDB-285x380.jpg",
        "Resident Evil 2"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/499463_IGDB-285x380.jpg",
        "Getting Over It"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/743-285x380.jpg",
        "Chess"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/459931_IGDB-285x380.jpg",
        "Old School RuneScape"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/489635-285x380.jpg",
        "Ark: Survival Evolved"
    ],
    [
        "https://static-cdn.jtvnw.net/ttv-boxart/687129551_IGDB-285x380.jpg",
        "Trackmania"
    ]
);

// usernames fetched from https://www.name-generator.org.uk/team/
$teams = array(
    "Australia Toads",
    "Australia Hamsters",
    "Australia Koalas",
    "Australia Angels",
    "Australia Blues",
    "Australia Blue Jackets",
    "Australia Blue Legs",
    "Australia United",
    "Australia Athletic",
    "Blue Toads",
    "Blue Hamsters",
    "Blue Koalas",
    "Blue Angels",
    "Delightful Toads",
    "Delightful Hamsters",
    "Delightful Koalas",
    "Delightful Angels",
    "Considerate Toads",
    "Considerate Hamsters",
    "Considerate Koalas",
    "Considerate Angels",
    "Helpful Toads",
    "Helpful Hamsters",
    "Helpful Koalas",
    "Helpful Angels",
    "New York Lizards",
    "New York Rabbits",
    "New York Newts",
    "New York Giants",
    "New York Blacks",
    "New York Black Jackets",
    "New York Black Legs",
    "New York United",
    "New York Athletic",
    "Black Lizards",
    "Black Rabbits",
    "Black Newts",
    "Black Giants",
    "Intelligent Lizards",
    "Intelligent Rabbits",
    "Intelligent Newts",
    "Intelligent Giants",
    "Admirable Lizards",
    "Admirable Rabbits",
    "Admirable Newts",
    "Admirable Giants",
    "Brutal Lizards",
    "Brutal Rabbits",
    "Brutal Newts",
    "Brutal Giants"
);

// bet groups
$betGroups = array(
    "Result",
    "Accolades",
    "Objectives",
    "Timestamps",
    "Scores"
);

$betsResultTypes = array(
    "Winner",
    "First Blood",
    "Gets Jungle Monster",
    "5 Headshots",
    "Kills 20",
    "No Deaths",
    "Gets 10 kill streak",
    "Scores 5 goals",
    "No Goals Against",
    "Get Last Kill",
);