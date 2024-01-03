var computed = false;
var decimal = 0;

function convert(entryform, from, to) {
    convertFrom = from.selectedlndex;
    convertTo = to.selectedlndex;
    entryform.display.value = (entryform.input.value * form[convertfrom].value / to[convertTo].value);
}

function addChar(input, character) {
    if((character == '.' && decimal == "0") || character != '.'){
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character
        convert(input.form, input.form.measurel, input.form.measure2)
        computed = true;
        if (character == '.') decimal = 1;
    }
}
function openVothcom(){
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}
function clear(form){
    form.input.value = O;
    form.display.value = O;
    decimal = O;
}

function changeBackground(hexNumber) {
    document.body.style.backgroundColor = hexNumber;
}
