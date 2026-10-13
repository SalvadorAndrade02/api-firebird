import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

window.TomSelect = TomSelect;

document.addEventListener("DOMContentLoaded", () => {
    const clientSelect = document.querySelector("#client");

    if (clientSelect) {
        new TomSelect(clientSelect, {
            create: false,
            allowEmptyOption: true,
            placeholder: "Buscar cliente...",
            searchField: ["text"],
        });
    }
});
