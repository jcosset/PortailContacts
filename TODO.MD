List tree um
create table mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, mode varchar(255))

create table liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, listeID int not null, modeID int NOT null,
FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
)

create table poste_liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, posteID int not null, listeID int not null, modeID int NOT null,
FOREIGN KEY (posteID) REFERENCES poste(id), FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
)

Formananager
Gestion poste
accronyme poste
14/12
ALTER TABLE Contact
ADD COLUMN telephone VARCHAR(255) null,
ADD COLUMN email_pro VARCHAR(255) null

ALTER TABLE Contact
ADD COLUMN commentaire_niv_2 LONGTEXT null,

Ajout Email_pro, telephone table, commentaire niv 2 contact

16/12/2022
create table address(id INT AUTO_INCREMENT PRIMARY KEY, Rue varchar(255), Compl varchar(255),
CP int, Ville varchar(255), Pays varchar(255),
)
ALTER TABLE address
ADD COLUMN cedex VARCHAR(255),

ALTER TABLE contact
ADD COLUMN addressID int;
ALTER TABLE contact ADD FOREIGN KEY (addressID) REFERENCES address(id);

CRUD LISTE

# 06/02/2023

Entite adresse mail
Mail Non obligatoire
Ajouter des étoiles fields
Migrer github flag

Finaliser

Entite
Poste
Cont

Ajout poste liste de diffusion directement modal modif poste

===========
Civilite Table
==========

// @i@

The problem
The problem consists in rendering events on a calendar, avoiding overlapping events to visually overlap.
Your implementation should meet the two following constraints:

Every overlapping event should have the same width as every event it overlaps
Every event should use the maximum width available while satisfying constraint 1

A visual illustration of the problem is given below.
Rendering events on a calendar means here: the relative position of events to the top of the screen and their height is a function of the height of the screen, the start/end time of the calendar, and the start time/duration of the events. For example: if the calendar goes from 00:00 to 24:00 and the screen is 2400px high, an event starting at 12:00 and lasting 1h would be positioned at 1200px of the top of the screen and have a height of 100px.
Using the maximum width available here implies that the width of every group of mutually overlapping events equals the width of the window.

The input
The input (available below) is an array of events occurring on the same date. They have the following structure:

[
{
"id": 1,
"start": "17:00",
"duration": 60
},
{
"id": 2,
"start": "17:00",
"duration": 120
},
{
"id": 3,
"start": "19:40",
"duration": 10
},
{
"id": 4,
"start": "15:00",
"duration": 20
},
{
"id": 5,
"start": "18:00",
"duration": 60
},
{
"id": 6,
"start": "10:25",
"duration": 35
},
{
"id": 7,
"start": "10:45",
"duration": 30
},
{
"id": 8,
"start": "17:00",
"duration": 60
},
{
"id": 9,
"start": "10:00",
"duration": 30
},

]

The output
Your code should render the events on a webpage in a container spanning the whole window.
The top of the page represents 09:00 am. The bottom of the page represents 09:00 pm.
The events should be represented as a div with a background color and a 1px border. The div should display the event's id.
Your implementation should be responsive (i.e. respond to window resize events).

Visual illustration of the problem
1 event
|

2 events

||
|

3 events where events 1, 2 and 3 overlap, but events 1 and 3 do not

|
|
|
|

The configuration above meets all constraints. Be careful, something like below would not meet constraint 2 :
|
|
|

If we combine cases 1, 2 and 3, you should end up with something like
The schema below assumes the width of event 1 equals the width of the window.

    	|

    | |
    |

    |
    		|

| |
| |
|

Satisfying both constraints
The schema below assumes the width of event 1 equals the width of the window.

[{start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}]

pynusu@lyft.live

NODEJS================
const createEE = ({ fn, interval, signal }) => {
const e = new EventEmitter();
e.once("data", fn)

    let setInt = setInterval(()=>{
        try {
            e.emit("data", fn())
        }catch(e){
            e.emit("error", e)
        }
    }, interval)

    signal.addEventListener("abort", ()=>{
        clearInterval(setInt)
        e.emit("close")
    })

    return e;

};

const serveFolder = (folderPath) => {
const server = http.createServer((req, res) => {
const filePath = path.join(folderPath, req.url);
fs.readFile(filePath, (err, data) => {
if (err) {
res.writeHead(404, { "Content-Type": "application/json" });
res.end(JSON.stringify({ error: { code: 404, message: `File ${folderPath} not found` } }));
} else {
res.writeHead(200, { "Content-Type": "text/plain" });
res.end(data);
}
});
});

      return server

    // Your code goes here

};

REACT===============
Quel est le comportement attendu vis-à-vis de la fonction shouldComponentUpdate du lifecycle telle qu'implémentée dans le code ci-dessous ?
Le composant ne se mettra pas à jour que ce soit au changement des props ou du state

SQL==================

== SELECT vehicle.VEHICLE_ID [8, 5]

SELECT vehicle.VEHICLE_ID
FROM vehicle left join vehicle_part on(vehicle.VEHICLE_ID = vehicle_part.VEHICLE_ID)
group by vehicle.VEHICLE_ID
having count(vehicle_part.VEHICLE_PART_ID) = 0

== make, model, FORD, F150

SELECT make, model
FROM vehicle
where vehicle_name like 'G%'
order by make
=========
Implémentez la fonction promisify(callbackFunction) de façon à ce qu'elle prenne une fonction basée sur un callback et renvoie une fonction basée sur une promesse.

La fonction basée sur la promesse peut être appelée avec un ou plusieurs arguments. Si c'est le cas, transmettez-les à callbackFunction, et ajoutez un argument à la fin pour le callback. En d'autres termes, la fonction basée sur la promesse sera toujours appelée avec un argument de moins que ce que la fonction basée sur le callback peut prendre.

La fonction basée sur la promesse doit obligatoirement être asynchrone.

Toutes les fonctions de callback renverront toujours un argument, qui devra être renvoyé par la fonction basée sur la promesse.

=========
dans cet exercice, vous allez utiliser le module cluster pour interagir avec des processus enfants (workers).

Un worker a été implémenté à l'emplacement workerPath. Il utilise une logique de calcul lourde pour le CPU. Le worker attend le message d'entrée du processus cluster primaire. Il calcule ensuite le résultat et le renvoie.

Votre objectif est d'implémenter la fonction asynchrone doCalculations(inputs, workerPath) qui envoie les entrées au worker et retourne les résultats du calcul.
inputs est une liste contenant la ou les chaînes de caractères à envoyer.
workerPath est une chaîne de caractères représentant le chemin du fichier du worker.
Votre fonction doit renvoyer un objet Promise qui se résout en un tableau de résultats.
Les calculs doivent être exécutés en parallèle.
L'ordre entre les entrées et les sorties doit être préservé.

============
Dans cet exercice nous allons calculer une estimation du nombre π (Pi).

La technique est la suivante :
On prend un point P au hasard de coordonnées (x, y) tel que 0 ≤ x ≤ 1 et 0 ≤ y ≤ 1. Si x² + y² ≤ 1, alors le point est à l'intérieur du quart de disque de rayon 1, sinon le point est à l'extérieur.

Fig 1. Exemple avec 33 points aléatoires.

On sait que la probabilité que le point se situe à l'intérieur du quart de disque est égale à π/4.

Écrivez la méthode approx(pts) qui va utiliser le tableau de points pts (tirés au hasard) pour retourner une estimation du nombre π.

Données :
Chaque item de pts contient un point.
Un point est représenté par un tableau contenant exactement deux nombres, respectivement x et y tels que 0 ≤ x ≤ 1 et 0 ≤ y ≤ 1.
pts n'est jamais null et contient toujours au moins un item.

function approx(pts) {
let count = 0;
const total = pts.length;

for (let i = 0; i < total; i++) {
const [x, y] = pts[i];
if (x _ x + y _ y <= 1) {
count++;
}
}

const ratio = count / total;
const pi = ratio \* 4;
return pi;
}

===============

Implémentez la fonction filterStream(inputStream, regexp) avec les exigences suivantes :

inputStream est un stream accessible en lecture qui émet des lignes de données (sous forme de chaînes UTF-8).
regexp est un objet RegExp qui est utilisé pour filtrer les données inputStream.
Votre fonction doit retourner un stream avec les éléments correspondant à l'expression régulière.

Exemple :

// Input stream data
"aaa", "aAa", "aab"

// regexp
/aaa/i

// Output stream data
"aaa", "aAa"

const regexTransform = new stream.Transform({
transform(chunk, encoding, callback) {
const lines = chunk.toString().split('\n');
for (let i = 0; i < lines.length; i++) {
const line = lines[i];
if (regexp.test(line)) {
this.push(line);
}
}
callback();
}
});
inputStream.pipe(regexTransform);
return regexTransform;

============ React

// Modify this component so that it behaves properly

function ResultDisplayer({ getNewResult }){
const [result, setResult] = useState(null)

    function handleClick(){
        setResult(getNewResult())
    }

    return (<div>
        <button id="button" onClick={handleClick}>Click</button>
        {result != null && <span id="result">{result}</span>}
    </div>);

}

// Modify this function if you want to change the preview
// It will not be evaluated as part of the assessment
export function Preview() {
return <ResultDisplayer getNewResult={() => 'test'} />;
}

// Do not change
export default ResultDisplayer;
