$(document).ready(function () {
  $('input[type="checkbox"]').on('change', function () {
    var id = $(this).next().val();
    var isChecked = $(this).is(':checked');
    var status = isChecked ? 'Done' : 'On Progress';

    $.post('update_status.php', { id: id, status: status }, function (data) {
      location.reload();
    });
  })
});

AOS.init();






