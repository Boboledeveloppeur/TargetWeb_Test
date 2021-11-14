var adresses = document.getElementsByTagName('title')[0].innerText;

if (adresses == 'Melting Pot | Adresses') {

  var frDate = new Date();
  var display = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };
  document.getElementById('target').innerHTML = (frDate.toLocaleDateString('fr-CA', display));

  var datum = new Date();
  var mention = '';

  if (datum.getDay() == 1 || datum.getHours() >= 23 && datum.getHours() < 12) {
    mention = 'fermé';
  } else {
    mention = 'ouvert';
  }

  document.getElementById('mention').innerText = mention;

};


var accueil = document.getElementsByTagName('title')[0].innerText;

if (accueil == 'Melting Pot | Accueil') {
  var username = prompt("Quel est ton prénom ?");
  document.getElementById("bienvenue").innerHTML = "Bienvenue " + username + " !";
};

$(".dropdown-toggle").dropdown();
