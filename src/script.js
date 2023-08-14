const url = "http://localhost:3000/todos";
function getALLtodos() {
    $.ajax({
        url: url,
        success: function (res) {
            res.forEach(todo => {
                generatetodo(todo);
            })
        }
    });
}

$(function () {
    getALLtodos();
    $('#description').on('input', function () {
        const charectersLeft = 100 - ($(this).val().length);
        console.log(charectersLeft);
        const spanText = `${charectersLeft} charecters Left` ;
        $('#textCount').text(spanText);
        if (charectersLeft <= 0) {
            $('#textCount').removeClass('text-green-600');
            $('#textCount').addClass('text-red-600');
            $('#description').addClass("border-2 border-rose-600 focus:border-2");
        } else {
            $('#textCount').addClass('text-green-600');
            $("#textCount").removeClass('text-red-600');
            $('#description').removeClass("border-2 border-rose-600 focus:border-2");
        }
    });
});