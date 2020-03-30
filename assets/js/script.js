// // Code goes here
//
// $(document).ready(function(){
//   var table = $('#IDexample').DataTable();
//
//   $('#btn-export').on('click', function(){
//       $('<table>').append(table.$('tr').clone()).table2excel({
//           exclude: ".excludeThisClass",
//           name: "Worksheet Name",
//           filename: "SomeFile" //do not include extension
//       });
//   });
// })
//

jQuery(document).ready(function() {
    $('#export-btn').on('click', function(e){
        e.preventDefault();
        ResultsToTable();
    });

    function ResultsToTable(){
        $("#IDexample").table2excel({
            exclude: ".noExl",
            name: "Results"
        });
    }
});
