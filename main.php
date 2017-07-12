<?php
  $con = mysqli_connect('localhost', 'root', '','transfer');
  date_default_timezone_set('Asia/Seoul');
  $now = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="CSS/map.css">
    <style>
      html, body {
        height: 80%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 120%;
      }
    </style>
      <title>view through bulldi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">
  </head>
  <body>
    <div id="map"></div>
      <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="shj.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">
                        <li class="active"><a href="#">bulldi</a></li>
                        <li><a href="history.php">히스토리 보기</a></li>
                        <li><a href="#" onClick = "toggleHeatmap()">실시간 화재 켜기/끄기</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->

    <!-- google maps -->
    <section id = "googlemaps">
     <div id="slider" class="sl-slider-wrapper">

        <!--Slider Items-->
        <div class="sl-slider">

        </div>
        <!--Slider Item3-->

    </div>
    <!--/Slider Items-->



</div>
<!-- /slider-wrapper -->

    </section>
<script>

var tempMarkers = [];
var COMarkers = [];
var SmokeMarkers = [];
var map;
var iconBase = 'http://13.124.11.28/bulldi/images/';

function initMap() {

  var mapCanvus = document.getElementById('map');
  var mapOption = {center : {lat:37.507957,lng:126.693900}, zoom :11};
  map = new google.maps.Map(mapCanvus,mapOption);
  var locations = new Array();
  var malocations = new Array();
  var maalocations = new Array();
  //  Table에서 빈도수, 경/위도 값 가져옴
  var color;

  //송도데이터.
  <?php
    $total_Count = 0;
    $query ="SELECT substr(transtime,1,10) AS DATA,count(*) AS COUNT,latitude,longitude FROM songdo_3data WHERE co>100 GROUP BY substr(transtime,1,10)";
    $exec = mysqli_query($con,$query) or die("쿼리문 실행에 실패했습니다");
    while($row = mysqli_fetch_array($exec)){
      $data = $row['DATA'];
      $count= $row['COUNT'];
      $latitude=$row['latitude'];
      $longitude=$row['longitude'];
      $total_Count +=1;
    }
    //처음에는 아무 정보 없으니 insert name를 기본키로 지정해 다른 데이터 바뀔 시 수정할 수 있도록.
    $query_test = "INSERT INTO all_data(name,count,latitude,longitude) VALUES('songdo',$total_Count,$latitude,$longitude) ON DUPLICATE KEY UPDATE name ='songdo', count = $total_Count,latitude=$latitude,longitude=$longitude";
    $exec = mysqli_query($con,$query_test);
    ?>

  //김포데이터.
  <?php
    $total_Count = 0;
    $query ="SELECT substr(transtime,1,10) AS DATA,count(*) AS COUNT,latitude,longitude FROM gimpo_3data WHERE co>100 GROUP BY substr(transtime,1,10)";
    $exec = mysqli_query($con,$query) or die("쿼리문 실행에 실패했습니다");
    while($row = mysqli_fetch_array($exec)){
      $data = $row['DATA'];
      $count= $row['COUNT'];
      $latitude=$row['latitude'];
      $longitude=$row['longitude'];
      $total_Count +=1;
    }
    //처음에는 아무 정보 없으니 insert name를 기본키로 지정해 다른 데이터 바뀔 시 수정할 수 있도록.
    $query_test = "INSERT INTO all_data(name,count,latitude,longitude) VALUES('gimpo',$total_Count,$latitude,$longitude) ON DUPLICATE KEY UPDATE name ='gimpo', count = $total_Count,latitude=$latitude,longitude=$longitude";
    $exec = mysqli_query($con,$query_test);
    ?>

    //작전 데이터
    <?php
      $total_Count = 0;
      $query ="SELECT substr(transtime,1,10) AS DATA,count(*) AS COUNT,latitude,longitude FROM jak_data WHERE co>100 GROUP BY substr(transtime,1,10)";
      $exec = mysqli_query($con,$query) or die("쿼리문 실행에 실패했습니다");
      while($row = mysqli_fetch_array($exec)){
        $data = $row['DATA'];
        $count= $row['COUNT'];
        $latitude=$row['latitude'];
        $longitude=$row['longitude'];
        $total_Count +=1;
      }
      //처음에는 아무 정보 없으니 insert name를 기본키로 지정해 다른 데이터 바뀔 시 수정할 수 있도록.
      $query_test = "INSERT INTO all_data(name,count,latitude,longitude) VALUES('jakjeon',$total_Count,$latitude,$longitude) ON DUPLICATE KEY UPDATE name ='jakjeon', count = $total_Count,latitude=$latitude,longitude=$longitude";
      $exec = mysqli_query($con,$query_test);
      ?>
      //서구데이터
      <?php
        $total_Count = 0;
        $query ="SELECT substr(transtime,1,10) AS DATA,count(*) AS COUNT,latitude,longitude FROM seogu_3data WHERE co>100 GROUP BY substr(transtime,1,10)";
        $exec = mysqli_query($con,$query) or die("쿼리문 실행에 실패했습니다");
        while($row = mysqli_fetch_array($exec)){
          $data = $row['DATA'];
          $count= $row['COUNT'];
          $latitude=$row['latitude'];
          $longitude=$row['longitude'];
          $total_Count +=1;
        }
        //처음에는 아무 정보 없으니 insert name를 기본키로 지정해 다른 데이터 바뀔 시 수정할 수 있도록.
        $query_test = "INSERT INTO all_data(name,count,latitude,longitude) VALUES('seogu',$total_Count,$latitude,$longitude) ON DUPLICATE KEY UPDATE name ='seogu', count = $total_Count,latitude=$latitude,longitude=$longitude";
        $exec = mysqli_query($con,$query_test);
        ?>


  <?php
  $query = "SELECT name,latitude,longitude,count FROM all_data ORDER BY count";
  $exec = mysqli_query($con, $query);

  while($row = mysqli_fetch_array($exec)){
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $count1 = $row['count'];
    $count = $row['count'];
    $count = $count / 2;

    if($count >0 && $count <=1){
      $count = 1;
      $radius = 300;
      ?> color = '#db6e08';
      <?php
    }

    else if($count >1 && $count <=3){
      $count = 2;
      $radius = 300;
      ?> color = "#d12727";
      <?php
    }
    else if($count >3 && $count <=4){
      $count = 3;
      $radius = 300;
      ?> color = "#a50808";
      <?php
    }
    else{
      $count = 4;
      $radius = 300; ?>
      color = "#a50808";
      <?php
    }
    if($latitude == '37.6331547'){
      (string)$gimpo = '경기도 김포시 걸포동';
    }
    else if ($latitude =='37.531669'){
      (string)$gimpo = '인천시 계양구 작전1동';
    }
    else if ($latitude =='37.375460'){
      (string)$gimpo = '인천광역시 연수구 송도동';
    }
    else{
      (string)$gimpo = '인천 서구 신현동';
    }
  ?>
  var content1 ='<div id="iw-container">' +
                  '<div class="iw-title">화재 현황</div>' +
                  '<div class="iw-content">' +
                    '<div class="iw-subTitle">총 발생 횟수</div>' +
                    '<p> <h4 style="color:red">'+
                    <?php echo $count1 ?>+
                    '회</h4>'+
                    '<div class="iw-subTitle">현재 장소</div>' +
                    '<p>'+
                    '<?php echo $gimpo ?>'+
                    '</p>'+
                    '<div class ="iw-subTitle">화재 대피 요령</div>'+
                    '<p>불을 발견하면 불이야 하고 큰소리로 외쳐서 다른 사람에게 알리고. 화재경보 비상벨을 누릅니다.<br>엘리베이터는 절대 이용하지 않도록 하며 계단을 이용합시다.<br>아래층으로 대피할 수 없는 때에는 옥상으로 대피합니다.</p>'+
                    '<p>화재 대피요령에 대한 자세한 내용은<br>'+
                    '<a href ="http://www.nfds.go.kr/fs_sense_0001.jsf?gb=v3">http://www.nfds.go.kr/fs_sense_0001.jsf?gb=v3</a><br>를 참고하세요' +
                  '<div class="iw-bottom-gradient"></div>' +
                '</div>';
      var lat = <?php echo $latitude ?>;

        for(var i =0 ; i<= <?php echo $count ?> ; i++) {
          var offset = i / 4000;
          var longitude = <?php echo $longitude?>;
          if(i == 0)
            longitude =longitude - (1/4000);
          else if(i == 1){
          longitude = longitude;
        }
        else{
          longitude +=offset-(1/4000);
        }

        //클러스터링에 넣을 마커별 멘트 및 위치를 malocations 좌표에 넣어줌
        var lon = longitude;
        malocations.push([
          content1,
          lat,
          lon
        ]);

        //클러스터링에 넣을 마커들 좌표 locations배열에 추가시킨다
        var myLatlng = new google.maps.LatLng(<?php echo $latitude ?>, longitude);
        locations.push({lat : <?php echo $latitude?>, lng :longitude });

        //마커 주위 원 찍어주기, 색상은 빈도별로 진하기로 나뉘어짐
        var myCity = new google.maps.Circle({
            center: {lat:<?php echo $latitude?>,lng:<?php echo $longitude?>},
            radius: <?php echo $radius?>,
            strokeColor: color,
            strokeOpacity: 0.3,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.3
  });
  myCity.setMap(map); //맵에 원 뿌려줌
  } // for문 종료

  var infowindow = new google.maps.InfoWindow({
    maxwidth : 200
  });
  var marker, i;
  for (i = 0; i <malocations.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(malocations[i][1],malocations[i][2]),
      icon : iconBase+'fire1.png', //마커로 사용할 이미지(투명 마커)
      map: map
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(malocations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }//for문 종료

  <?php  } ?>//while문 종료

  var markers = locations.map(function(location, i) {
         return new google.maps.Marker({
           position: location,
           icon : iconBase + 'marker1.png'
         });
});
       var markerCluster = new MarkerClusterer(map, markers,
    {imagePath: '/js/m/m'});

// initMap 종료
}


    </script>
    <script src="/js/markerclusterer.js">
   </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADZhjylXxCS2VvECDv1SAC2w5kFATvdVA&callback=initMap"></script>
  </body>
</html>
