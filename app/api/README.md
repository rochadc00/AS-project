# GameBET API
API that handles data from GameBET's databases

## API Documentation

1. [Users](#users)
    - 2.1 [Structure](#structure)
    - 2.2 [Get All Users](#get-all-users)
    - 2.3 [Filter Users By Key](#filter-users-by-key)
2. [Games](#games)
    - 2.1 [Structure](#structure)
    - 2.2 [Get All Games](#get-all-games)
    - 2.3 [Filter Games By Key](#filter-games-by-key)
3. [Streams](#streams)
    - 3.1 [Structure](#structure)
    - 3.2 [Get All Streams](#get-all-streams)
    - 3.3 [Filter Streams By Key](#filter-streams-by-key)
4. [Bets](#bets)
    - 4.1 [Structure](#structure)
    - 4.2 [Get All Bets](#get-all-bets)
    - 4.3 [Filter Bets By Key](#filter-bets-by-key)
5. [Get Only Specific Keys](#get-only-specific-keys)

## Users

Users contains information about the users of the app

### Structure

Example of the information fetched from **/users**:
```json
{
    "username": "IdealCobra",
    "email": "idealcobra@fakemail.com",
    "streamer": true,
    "id": "4",
    "games": [
        {
            "name": "League of Legends",
            "cover": "https://static-cdn.jtvnw.net/ttv-boxart/21779-285x380.jpg",
            "id": "2"
        },
        {
            "name": "Leap",
            "cover": "https://static-cdn.jtvnw.net/ttv-boxart/391992674_IGDB-285x380.jpg",
            "id": "34"
        },
        {
            "name": "Chess",
            "cover": "https://static-cdn.jtvnw.net/ttv-boxart/743-285x380.jpg",
            "id": "41"
        }
    ]
}
```

#### **Fields**
| ID | Name | Data Type | Description |
|----|------|-----------|-------------|
| **username** | Username | string | User name identifier | 
| **email** | Email | string | User email | 
| **streamer** | Streamer | boolean | Whether or not the user is partnered with GameBET, therefore being a streamer |
| **id** | User ID | string | User number identifier |
| **games** | Games | Game | Games streamed by the user |

### Get All Users

Fetch all users

**HTTP Request**

``` GET .../api/users```

### Filter Users by Key

Filter the list of users by the keys available. Some keys can be combined. Most of the *string* **Fields** are valid.

**Example HTTP Requests**

```
GET .../api/users?id=4
GET .../api/users?username=co&streamer=false
GET .../api/users?streamer=true
```

## Games

Games contains information about the games that contain streams with bets on the app

### Structure

Example of the information fetched from **/games**:
```json
{
    "name": "SMITE",
    "cover": "https://static-cdn.jtvnw.net/ttv-boxart/32507-285x380.jpg",
    "id": "37",
    "users": [
        {
            "username": "OurVole",
            "email": "ourvole@fakemail.com",
            "pwd": "123456",
            "streamer": "1",
            "id": "7"
        },
        {
            "username": "EvasiveGuillemot",
            "email": "evasiveguillemot@fakemail.com",
            "pwd": "123456",
            "streamer": "1",
            "id": "26"
        }
    ]
}
```

#### **Fields**
| ID | Name | Data Type | Description |
|----|------|-----------|-------------|
| **name** | Name | string | Name of the game | 
| **cover** | Cover | string | Link to the cover picture | 
| **id** | User ID | string | Game number identifier |
| **users** | Users | User | Users streaming the game |

### Get All Games

Fetch all games

**HTTP Request**

``` GET .../api/games```

### Filter Games by Key

Filter the list of games by the keys available.  Most of the *string* **Fields** are valid.

**Example HTTP Requests**

```
GET .../api/games?id=37
GET .../api/users?name=tr
```

## Streams

Streams contains information about the streams that had, have or will have bets on the app.

### Structure

Example of the information fetched from **/streams**:
```json
{
    "title": "Swine pork id nulla sint, adipisicing anim ham",
    "thumbnail": "https://picsum.photos/300/170?random=82",
    "viewers": "10209",
    "gameId": "38",
    "userId": "26",
    "platform": "Twitch",
    "matchFormat": "Tournment",
    "matchBeginning": "2022-06-02 19:07:34",
    "teamA": "Black Newts",
    "teamB": "Admirable Rabbits",
    "id": "83",
    "game": {
        "name": "Fall Guys: Ultimate Knockout",
        "cover": "https://static-cdn.jtvnw.net/ttv-boxart/512980-285x380.jpg",
        "id": "38"
    },
    "user": {
        "username": "EvasiveGuillemot",
        "email": "evasiveguillemot@fakemail.com",
        "streamer": "1",
        "money": "148",
        "points": "927",
        "id": "26"
    }
}
```

#### **Fields**
| ID | Name | Data Type | Description |
|----|------|-----------|-------------|
| **title** | Title | string | Stream title | 
| **thumbnail** | Thumbnail | string | Stream thumbnail | 
| **viewers** | Viewers | string | Amount of viewers of the stream |
| **gameId** | Game ID | string | Game number identifier |
| **userId** | User ID | string | User number identifier |
| **platform** | Platform | string | Platform hosting the stream |
| **matchFormat** | Match Format | string | If the match is a Tournment or just Casual |
| **matchBeginning** | Match Beginning | ISO-8061 | Date of the beginning of the match |
| **teamA** | Team A | string | One of the teams playing the match |
| **teamB** | Team B | string | One of the teams playing the match |
| **id** | Stream ID | string | Stream number identifier |
| **game** | Game | Game | Game being streamed |
| **user** | User | User | User streaming |

### Get All Streams

Fetch all streams

**HTTP Request**

``` GET .../api/streams```

### Filter Streams by Key

Filter the list of streams by the keys available. Some keys can be combined. Most of the *string* **Fields** are valid.

**Example HTTP Requests**

```
GET .../api/users?id=83
GET .../api/users?title=swine&matchFormat=Tournment&platform=Twitch
GET .../api/users?platform=Youtube&team=Black Newts
```

## Bets

Bets contains information about the bets from every stream.

### Structure

Example of the information fetched from **/bets**:
```json
{
    "streamId": "173",
    "betGroup": "Objectives",
    "resultType": "Gets 10 kill streak",
    "resultTeam": "Australia Toads",
    "odd": "9.86",
    "id": "1580",
    "stream": {
        "title": "Lorem bacon drumstick culpa ad anim shoulder turkey sausage est",
        "thumbnail": "https://picsum.photos/300/170?random=172",
        "viewers": "90760",
        "gameId": "3",
        "userId": "37",
        "platform": "Youtube",
        "matchFormat": "Casual",
        "matchBeginning": "2022-06-02 23:28:14",
        "teamA": "Black Newts",
        "teamB": "Australia Toads",
        "id": "173"
    }
}
```

#### **Fields**
| ID | Name | Data Type | Description |
|----|------|-----------|-------------|
| **streamId** | Stream ID | string | Stream number identifier | 
| **betGroup** | Bet Group | string | Group that dictates the type of bet | 
| **resultType** | Result Type | string | Bet small description |
| **resultTeam** | Result Team | string | Team targeted by the bet |
| **odd** | Odd | string | Value of the bet |
| **id** | Bet ID | string | Bet number identifier |
| **stream** | Stream | Stream | Stream that the bet refers to |

### Get All Bets

Fetch all bets

**HTTP Request**

``` GET .../api/bets```

### Filter Bets by Key

Filter the list of bets by the keys available. Some keys can be combined. Most of the *string* **Fields** are valid.

**Example HTTP Requests**

```
GET .../api/bets?id=1580
GET .../api/bets?resultTeam=Australia Toads&resultType=5 Headshots
```

## Get Only Specific Keys

When making any HTTP request, providing the URL Parameter *"keys"* will only show those specific keys (see **Fields** to know which keys are valid).

An example, is the following: 
**HTTP Request**

``` GET .../api/users?id=4&keys=id,username```

It responds with the following data:
```json
{
    "username": "IdealCobra",
    "id": "4"
}
```

Keys that don't represent *strings* will work too, as it shows in the following example:
**HTTP Request**

``` GET .../api/streams?team=Black%20Rabbits&keys=title,viewers,game,teamA,teamB```

It responds with the following data:
```json
{
    "title": "Ipsum salami short ribs reprehenderit sint landjaeger non capicola swine cillum shankle aute veniam",
    "viewers": "78590",
    "teamA": "Black Rabbits",
    "teamB": "Blue Koalas",
    "id": "23",
    "gameId": "39",
    "game": {
        "name": "Resident Evil 2",
        "cover": "https://static-cdn.jtvnw.net/ttv-boxart/8645_IGDB-285x380.jpg",
        "id": "39"
    }
}
```

Keys that don't exist will be ignored.
