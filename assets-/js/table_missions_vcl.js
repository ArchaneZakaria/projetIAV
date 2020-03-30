$( document ).ready(function() {
  function initDatePicker() {
    $('.month_datepicker').MonthPicker({
          ShowIcon: false,
          SelectedMonth: new Date().getMonth() + 1 +'/'+ new Date().getFullYear(),
          OnAfterChooseMonth: function(selectedDate) {
            $(this).closest('tr').find('input').removeClass('jour_mois_prise');
            var td = $(this).closest('tr').find('.jours_pris');
            var monthIndex = selectedDate.getMonth()+1;
            if(monthIndex<10){
              monthIndex = "0"+monthIndex;
            }
            var year = selectedDate.getFullYear();
            var id_chauffeur = $(this).closest('tr').find('.chauffeur_prmy').attr('id');
            console.log(id_chauffeur);
            $.ajax({
            type: 'POST',
            url: base_url + 'ordre_mission/getMission/GetChauffeurSearch_Aj',
            dataType: "html",
            data: {monthIndex:monthIndex,year:year,id_chauffeur:id_chauffeur},
            cache:false,
            success: function(data){
              td.html(data);
            }
             });
          }
      });
  }
  initDatePicker();
  $('#mission_vehicule_vcl').DataTable();
  $('#mission_vehicule_vcl').on( 'page.dt', function () {
    initDatePicker();
   });
});
