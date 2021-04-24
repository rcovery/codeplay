function toggle_theme(){
    let els = document.getElementsByClassName("color")

    for (let i = 0; i < els.length; i++){
        console.log('color changed!')
        els[i].classList.toggle("dark")
    }
}

function update_file_input(value, id){
    // document.getElementById("tmp_thumb").src = el.value
    // Caso eu queira usar imagem carregada do computador.
    // Pesquisar por FileReader()
    document.getElementById(id).innerHTML = value.split('\\')[2]
}