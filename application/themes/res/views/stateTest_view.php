<html>
<head>
  <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>

</head>
<body>

  <?php
/*** liste des années des retraités **/
  $queryDetailATAnn = $this->db->query(" SELECT distinct YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite

  FROM retraite
  JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
  cadre.deleted_cadre = 'N')
  JOIN regime on (retraite.id_regime = regime.id_regime AND
  regime.deleted_regime = 'N')
  JOIN cadretype ON (cadretype.id = retraite.id_cadre_type AND cadretype.deleted_cadreType = 'N')
  JOIN parametre ON (regime.id_regime = parametre.regime AND
  cadre.id_cadre = parametre.cadre AND
           (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
  JOIN retraite.position on (retraite.id_position = position.id_position)
  WHERE retraite.deleted_retraite ='N' AND
    retraite.status_retraite ='E'

  Group by DateRetraite,cadre.id_cadre ");
  $chart_datasATn = '';
  foreach($queryDetailATAnn->result() as $rowDetaiATT ){
   $chart_datasATn .= $rowDetaiATT->DateRetraite.",";
}

  // print_r($chart_datasATn);
/*** liste des années des retraités **/

$queryDetailCadre = $this->db->query("select * from cadretype ");


  $chart_datasAT = '';
  $cadreTypeName='';
  foreach($queryDetailCadre->result() as $rowDetaiAT ){
  $cadreType= $rowDetaiAT->id;
  $cadreTypeName= $rowDetaiAT->libelle_cadreType;
  $nbR_type_cadre='';
  foreach($queryDetailATAnn->result() as $rowDetaiATT ){
   $dateRet = $rowDetaiATT->DateRetraite;
    $queryDetailATDate = $this->db->query("SELECT cadretype.libelle_cadreType,cadre.id_cadre,cadre.libelle_cadre,YEAR(DATE_ADD(retraite.date_naissance_retraite,INTERVAL (parametre.age_retraite_parametre) YEAR))  AS DateRetraite,

                                    			count(retraite.id_retraite) as nb_ret
                                    FROM retraite
                                    JOIN cadre on (retraite.id_cadre = cadre.id_cadre AND
                                    cadre.deleted_cadre = 'N')
                                    JOIN regime on (retraite.id_regime = regime.id_regime AND
                                    regime.deleted_regime = 'N')
                                    JOIN parametre ON (regime.id_regime = parametre.regime AND
                                    cadre.id_cadre = parametre.cadre AND
                                                 (YEAR(retraite.date_naissance_retraite) BETWEEN SUBSTRING(parametre.condition_parametre,1,4) AND SUBSTRING(parametre.condition_parametre,6,4)))
                                    JOIN retraite.position on (retraite.id_position = position.id_position)
                                    JOIN cadretype ON (cadretype.id = retraite.id_cadre_type AND cadretype.deleted_cadreType = 'N')
                                    WHERE retraite.deleted_retraite ='N' AND
                                    			retraite.status_retraite ='E'

                                    Group by DateRetraite,cadretype.id
                                    having cadretype.id='". $cadreType ."' AND DateRetraite = '" . $dateRet . "'");


$nbR_type_cadr = $queryDetailATDate->row();
if(isset($nbR_type_cadr->id_cadre) && !empty($nbR_type_cadr->id_cadre)){
$nbR_type_cadre .= $nbR_type_cadr->id_cadre.',';
}else{
$nbR_type_cadre .= '0'.',';
}
 // if($nbR_type_cadr != ''){
 //   $nbR_type_cadre .=$nbR_type_cadr.',';
 // }else{
 //    $nbR_type_cadre .='0'.',';
 // }

}

  $AT = 0;
  $ENS = 0;

  // foreach($queryDetailATDate->result() as $resultByDate){
  //
  //   switch($resultByDate->id_cadre){
  //     case '1':
  //     $ENS = $resultByDate->nb_ret;
  //     continue;
  //     case '2':
  //     $AT = $resultByDate->nb_ret;
  //     continue;
  //   }
  // }
$chart_datasAT .= "{ name:'".$cadreTypeName ."', data: [$nbR_type_cadre],},";


     //$chart_datasAT .= "{ name:'".$rowDetaiAT->libelle_cadreType ."', data: [" . $rowDetaiAT->DateRetraite . "," . $rowDetaiAT->nb_ret."],},";

  }

$Chart_dataAT = substr($chart_datasAT, 0, -1);
  print_r($Chart_dataAT);
//
//    ?>
<script>
Highcharts.chart('container', {
  chart: {
    type: 'area'
  },
  title: {
    text: 'Nombre des retraités par cadre '
  },
  subtitle: {
    text: 'Source: IAV HASSAN II'
  },
  xAxis: {
    categories: [<?= $chart_datasATn ?>],
    tickmarkPlacement: 'on',
    title: {
      enabled: false
    }
  },
  yAxis: {
    title: {
      text: 'nbr des retraités'
    }
  },
  tooltip: {
    pointFormat: '<span style="color:{series.color}">{series.name}</span>: ({point.y:,.0f} retraités)<br/>',
    split: true
  },
  plotOptions: {
    area: {
      stacking: 'percent',
      lineColor: '#ffffff',
      lineWidth: 1,
      marker: {
        lineWidth: 1,
        lineColor: '#ffffff'
      }
    }
  },
  series: [<?= $chart_datasAT ?>]
});
</script>
</body>

</html>
