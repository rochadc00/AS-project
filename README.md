# GameBET

## Project for Análise de Sistemas (System Analysis)

Departamento de Electrónica, Telecomunicações e Informática - Universidade de Aveiro

## [API Documentation](app/api/README.md)

## Setup
To setup the app, first make sure to have **Docker** [[How to here]](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04) and **Docker Compose** [[How to here]](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04) running on your machine.


- Configure the database on **db-config.json** (this file must be present)
```json5
{
    "host": "<host of MySQL>", // (localhost, etc)
    "username": "<MySQL user>", // (root, etc)
    "password": "<password of user>",
}
```

- Create **secret.php** file
```bash
$ sudo chmod +x secret.sh
$ ./secret.sh
```

- Assemble and run the necessary containers
```bash
$ docker-compose up --build
```

The server will, then, be running on [localhost:80](http://localhost:80).

---
## Login Users

```javascript
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
```
Password to all users: 123456

---
## Tests w/ Selenium

Na pasta **/tests** tem lá um exemplo de um caso de uso testado no Seleniumn IDE.


---
## Equipa
| Name | Github | Email |  Contribuição(%) |
|------|--------|-------|-------|
| Diana Rocha | [rochadc00](https://github.com/rochadc00) | rochadc00@ua.pt | 25
| Diogo Correia | [digas99](https://github.com/digas99) | diogo.correia99@ua.pt | 25
| Gil Fernandes | [GilFernandes2000](https://github.com/GilFernandes2000) | joaogilfernandes@ua.pt | 25
| Gonçalo Maranhão | [GoncaloMaranhao](https://github.com/GoncaloMaranhao) | goncalo.rodrigues@ua.pt | 25