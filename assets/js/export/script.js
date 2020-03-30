// Code goes here

$(document).ready(function(){
  var table = $('#IDexample').DataTable();

  $('#btn-export').on('click', function(){
    alert('dd');
      $('table').append(table.$('tr').clone()).table2excel({
          exclude: ".excludeThisClass",
          name: "Worksheet Name",
          filename: "SomeFile" //do not include extension
      });
  });
})
