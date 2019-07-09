$(document).ready(function() {

    // =======================================================
    // Mascaras
    // =======================================================

    $('#input-valor').mask('000000000000000.00', {reverse: true});
    $('#input-desconto').mask('000000000000000.00', {reverse: true});


    // =======================================================
    // SELECTS
    // =======================================================

    // Formato da opção de categoria
    function formatCat (cat) {
        if (!cat.id) {
            return cat.text;
        }
        var baseUrl = "/img/icones-cat-subcat/categorias/sem";
        
        var $cat = $(
            '<span><img src="' + baseUrl + '/' + cat.text.toLowerCase() + '.png" class="img-cat float-right" /> ' + cat.text + '</span>'
        );
        return $cat;
    }

    // Inicializações
    $('#select-categorias').select2({
        placeholder: "Categorias",
        templateResult: formatCat,
        allowClear: true
    });
    $('#select-subcategorias').select2({
        placeholder: "Selecione uma categoria"
    });
    $('#select-comprador').select2({
        placeholder: "Selecione um comprador"
    });

    // Ao mudar a categoria, preenche as subcategorias
    $('#select-categorias').change(function() {
        var cat = $(this).val();
        
        $.ajax({
            url: 'scripts/recuperar-subcategorias.php',
            method: 'POST',
            data: {
                categoria: cat
            },
            datatype: 'html',
            success: function(retorno) {

                $('#select-subcategorias').attr('multiple', 'multiple');
                $('#select-subcategorias').html(retorno);
                $('#select-subcategorias').select2({
                    placeholder: "Subcategorias"
                });
            },
            error: function(retorno) {
                console.log('Error');
                console.log(retorno);
            }
        });

    });


    // =======================================================
    // Datepicker
    // =======================================================

    $('#input-data').datepicker({
        language: 'pt-BR',
        position: 'bottom center',
        autoClose: true,
        todayButton: new Date(),
        maxDate: new Date()
    });


    // =======================================================
    // Realiza a busca por observações já existentes
    // =======================================================

    $('#input-obs').autocomplete({
        minLength: 4
    });
    $('#input-obs').keyup(function() {
    
        var obs = $(this).val();

        if (obs.length >= 4) {
            $.ajax({
                url: 'scripts/busca-observacao.php',
                method: 'POST',
                data: {
                    busca: "sim",
                    texto: obs
                },
                datatype: 'html',
                success: function(retorno) {

                    var json = JSON.parse(retorno);
                    $('#input-obs').autocomplete({
                        minLength: 4,
                        source: json
                    });

                    $(this).focus();

                },
                error: function(retorno) {
                    console.log('Error');
                    console.log(retorno);
                }
            });
        }            

    });

});


// =======================================================
// Para uso do Cropper.js
// =======================================================

var cropper;

$('#input-imagem').on( 'change', function(e){

    if (this.files && this.files[0]) {
        var arquivos = this.files;
        var arquivo = arquivos[0];
        if ( arquivo.type.match(/^image\//) ) {

            // Cria o elemento da imagem
            $('#canvas').html('<img id="imagem-nota" alt="Imagem nota">');

            var imagem = document.getElementById("imagem-nota");
            $('#imagem-nota').attr("src", window.URL.createObjectURL(arquivo));

            // Cria o Cropper
            cropper = new Cropper(imagem, {
                aspectRatio: NaN,
                zoomable: false
            });

            // Adiciona o botao para cortar
            $('#modal-upload-imagem .modal-footer').html('<input type="button" class="btn btn-light btn-cortar" value="Cortar">');


            // Adiciona o nome do arquivo ao label do input
            var label	 = $('#input-imagem').siblings('label');
            var labelVal = label.val();

            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{numero}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.children('span').text(fileName);
            else
                label.innerHTML = labelVal;


            // Coloca a imagem cortada no canvas
            $('.btn-cortar').click(function() {
                
                // Recupera a imagem em base64
                var croppedImageDataURL = cropper.getCroppedCanvas().toDataURL("image/jpeg", 0.2);
                $('input[type="hidden"][name="imagem-cortada"]').val(croppedImageDataURL);
                
                // Adiciona a imagem cortada ao canvas
                $('#canvas').html('<img src="'+croppedImageDataURL+'" alt="Imagem cortada">');
                arquivo = croppedImageDataURL;

                // Muda para imagem selecionada
                $('.status-upload').removeClass('text-danger');
                $('.status-upload').addClass('text-success');
                $('.status-upload').html('<i class="fas fa-check-circle"></i> Imagem selecionada');
            });

        }
        else {
            alert("Invalid file type! Please select an image file.");
        }
    }
    else {
        alert('No file(s) selected.');
    }
});