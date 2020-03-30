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
            var id_vehicule = $(this).closest('tr').find('.matricule').attr('id');
            console.log(id_vehicule);
            $.ajax({
            type: 'POST',
            url: base_url + 'ordre_mission/getMission/GetMissions_Aj',
            dataType: "html",
            data: {monthIndex:monthIndex,year:year,id_vehicule:id_vehicule},
            cache:false,
            success: function(data){
              td.html(data);
            }
             });
          }
      });
  }
  function initDatePicker_global() {

    $('.month_datepicker_global').MonthPicker({
          ShowIcon: false,
          OnAfterChooseMonth: function(selectedDate) {
            console.log(selectedDate);
            var monthIndex = selectedDate.getMonth()+1;
            if(monthIndex<10){
              monthIndex = "0"+monthIndex;
            }
            var year = selectedDate.getFullYear();
            $.ajax({
            type: 'POST',
            url: base_url + 'ordre_mission/getMission/GetMissions_Aj_global',
            dataType: "html",
            data: {monthIndex:monthIndex,year:year},
            cache:false,
            success: function(data){
             $(".rslt_search").html(data);
             $("input[name='month']").val(monthIndex+"/"+year);
            }
             });
          }
      });

  }

  initDatePicker_global();
  initDatePicker();
$('.mission-vehicule').DataTable(
{
	"paging" : true,
});
$('.mission-vehiculee').DataTable(
{
	"paging" : false,
});
  $('.mission-vehicule').on( 'page.dt', function () {
    initDatePicker_global();
    initDatePicker();
   });

});
$(document).on('click','.jour_mois_prise',function () {
  var data     = $(this).attr('data');
  if(data != ''){
    var data_tab = data.split(",");
       $('#modaldel-id').find('.modal-title').text('Êtes-vous sûr de vouloir Modifiez La mission.');
       $("#date_debut").val(data_tab[0]);
       $("#date_fin").val(data_tab[1]);
       $("#mtr_ms").html(data_tab[6]);
       $("#mtr_ms").val(data_tab[5]);
       $("#chf_ms").html(data_tab[2]+" "+data_tab[3]);
       $("#chf_ms").val(data_tab[4]);
       $('#modaldel-id').modal('show');
  }

});
