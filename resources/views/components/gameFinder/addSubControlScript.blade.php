<script>
    let quantity = 2;

    function add(name) {
        let quantityOfElements =  (quantity + 1) - document.getElementsByName(name + "[]").length;

        if (quantityOfElements > 0) {
            const div = document.getElementById(name + "Div");
            const genre = document.getElementById(name).cloneNode(true);
            div.appendChild(genre);
            quantityOfElements--;
        }

        showHide(quantityOfElements, name);
    }

    function sub(name) {
        let quantityOfElements = (quantity + 1) - document.getElementsByName(name + "[]").length;

        if (quantityOfElements >= 0 && quantityOfElements < quantity) {
            const genre = document.getElementsByName(name + "[]")
            let quantity = genre.length;
            genre.item(quantity - 1).remove();
            quantityOfElements++;
        }

        showHide(quantityOfElements, name);
    }

    function showHide(quantityOfElements, name) {
        switch (true) {
            case (quantityOfElements === quantity):
                hide("sub" + name.charAt(0).toUpperCase() + name.slice(1));
                break;
            case (quantityOfElements === 0):
                hide("add" + name.charAt(0).toUpperCase() + name.slice(1));
                break;
            default:
                show("add" + name.charAt(0).toUpperCase() + name.slice(1));
                show("sub" + name.charAt(0).toUpperCase() + name.slice(1));
                break;
        }
    }

    function hide(name) {
        const element = document.getElementById(name);
        element.style.visibility = 'hidden';
    }

    function show(name) {
        const element = document.getElementById(name);
        element. style.visibility = 'visible';
    }
</script>
