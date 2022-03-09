import {Controller} from "@hotwired/stimulus";
import toastr from 'toastr';

// un controller doit impérativement être enregistré dans bootstrap.js
export default class extends Controller {
    // cette methode n'est appelée que si l'html
    // possède une div qui possede l'attribut data-controller="toastr"
    connect() {
        // la div qui a été utilisée pour appelée le controller
        // console.log(this.element);

        // recupere l'attribut message de la div
        // let message = this.element.getAttribute('data-message');
        // let status = this.element.getAttribute('data-status');

        // forme raccourcie en javascript pour recupérer les attributs data-...
        const { message, status } = this.element.dataset;

        toastr[status](message);
    }
}