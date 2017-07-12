<?php
  $con = mysqli_connect('localhost', 'root', '','transfer');
  date_default_timezone_set('Asia/Seoul');
  $now = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      html, body {
        height: 80%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 120%;
      }
      #floating-panel {
        background-color: #fff;
        border: 1px solid #999;
        left: 10%;
        padding: 5px;
        position: fixed;
        top: 10%;
        z-index: 5;
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
    <div id="floating-panel">
      <button onclick="toggleHeatmap()">실시간 화재감지 켜기/끄기</button>
    </div>
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
                <a id="logo" class="pull-left" href="main.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">
                        <li class="active"><a href="#" onClick="clearMarkers()">마커 초기화</a></li>
                        <li><a href="#" onClick = "view_tempMarkers()">온도 히스토리</a></li>
                        <li><a href="#" onClick = "view_SmokeMarkers()">연기 히스토리</a></li>
                        <li><a href="#" onClick = "view_COMarkers()">일산화탄소 히스토리</a></li>
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
//setTimeout("location.reload()",2000)
var map, heatmap;
var TempMarkers = [];
var COMarkers = [];
var SmokeMarkers = [];

var iconBase = 'images/';
        var icons = {
          temp: {
            icon: iconBase + 'temperature.png'
          },
          CO: {
            icon: iconBase + 'CO.png'
          },
          smoke: {
            icon: iconBase + 'smoke.png'
          }
};

var Tempfeatures = [
  {
    position: {lat: 37.6331547, lng: 126.7060423},
    type: 'temp'
  }, {
    position: {lat: 37.531669, lng: 126.731472},
    type: 'temp'
  }, {
    position: {lat: 37.517094, lng: 126.6698924},
    type: 'temp'
  }, {
    position: {lat: 37.375555, lng: 126.632864},
    type: 'temp'
  }
];

var COfeatures = [
  {
    position: {lat: 37.6331547, lng: 126.7060423},
    type: 'CO'
  }, {
    position: {lat: 37.4939292, lng: 126.7220893},
    type: 'CO'
  }, {
    position: {lat: 37.517094, lng: 126.6698924},
    type: 'CO'
  }, {
    position: {lat: 37.375555, lng: 126.632864},
    type: 'CO'
  }
];

var Smokefeatures = [
  {
    position: {lat: 37.6331547, lng: 126.7060423},
    type: 'smoke'
  }, {
    position: {lat: 37.4939292, lng: 126.7220893},
    type: 'smoke'
  }, {
    position: {lat: 37.517094, lng: 126.6698924},
    type: 'smoke'
  }, {
    position: {lat: 37.375555, lng: 126.632864},
    type: 'smoke'
  }
];

function view_tempMarkers() {
  clearMarkers();

  addTempMarker(Tempfeatures[0]);
  google.maps.event.addListener(TempMarkers[0], "click", function() {
    TemppopupOpen_Gim();
  });
  addTempMarker(Tempfeatures[1]);
  google.maps.event.addListener(TempMarkers[1], "click", function() {
    TemppopupOpen_Jak();
  });
  addTempMarker(Tempfeatures[2]);
  google.maps.event.addListener(TempMarkers[2], "click", function() {
    TemppopupOpen_Seo();
  });
  addTempMarker(Tempfeatures[3]);
  google.maps.event.addListener(TempMarkers[3], "click", function() {
    TemppopupOpen_Song();
  });
}

function view_COMarkers() {
  clearMarkers();

  addCOMarker(COfeatures[0]);
  google.maps.event.addListener(COMarkers[0], "click", function() {
    COpopupOpen_Gim();
  });
  addCOMarker(COfeatures[1]);
  google.maps.event.addListener(COMarkers[1], "click", function() {
    COpopupOpen_Jak();
  });
  addCOMarker(COfeatures[2]);
  google.maps.event.addListener(COMarkers[2], "click", function() {
    COpopupOpen_Seo();
  });
  addCOMarker(COfeatures[3]);
  google.maps.event.addListener(COMarkers[3], "click", function() {
    COpopupOpen_Song();
  });
}

function view_SmokeMarkers() {
  clearMarkers();

  addSmokeMarker(Smokefeatures[0]);
  google.maps.event.addListener(SmokeMarkers[0], "click", function() {
    SmokepopupOpen_Gim();
  });
  addSmokeMarker(Smokefeatures[1]);
  google.maps.event.addListener(SmokeMarkers[1], "click", function() {
    SmokepopupOpen_Jak();
  });
  addSmokeMarker(Smokefeatures[2]);
  google.maps.event.addListener(SmokeMarkers[2], "click", function() {
    SmokepopupOpen_Seo();
  });
  addSmokeMarker(Smokefeatures[3]);
  google.maps.event.addListener(SmokeMarkers[3], "click", function() {
    SmokepopupOpen_Song();
  });
}

function addTempMarker(Tempfeature) {
  TempMarkers.push(new google.maps.Marker({
    position: Tempfeature.position,
    icon: icons[Tempfeature.type].icon,
    map: map
  }));
}

function addCOMarker(COfeature) {
  COMarkers.push(new google.maps.Marker({
    position: COfeature.position,
    icon: icons[COfeature.type].icon,
    map: map
  }));
}

function addSmokeMarker(Smokefeature) {
  SmokeMarkers.push(new google.maps.Marker({
    position: Smokefeature.position,
    icon: icons[Smokefeature.type].icon,
    map: map
  }));
}

function clearMarkers() {
  for (var i = 0; i < TempMarkers.length; i++) {
    TempMarkers[i].setMap(null);
  }
  TempMarkers = [];
  for (var i = 0; i < COMarkers.length; i++) {
    COMarkers[i].setMap(null);
  }
  COMarkers = [];
  for (var i = 0; i < SmokeMarkers.length; i++) {
    SmokeMarkers[i].setMap(null);
  }
  SmokeMarkers = [];
}

function TemppopupOpen_Seo() {
  var popUrl = "Graph/seogu_temp_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function TemppopupOpen_Jak() {
  var popUrl = "Graph/Jakjun_temp_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function TemppopupOpen_Gim() {
  var popUrl = "Graph/Gimpo_temp_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function TemppopupOpen_Song() {
  var popUrl = "Graph/Songdo_temp_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}

function COpopupOpen_Seo() {
  var popUrl = "Graph/Seogu_CO_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function COpopupOpen_Jak() {
  var popUrl = "Graph/Jakjun_CO_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function COpopupOpen_Gim() {
  var popUrl = "Graph/Gimpo_CO_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function COpopupOpen_Song() {
  var popUrl = "Graph/Songdo_CO_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}

function SmokepopupOpen_Seo() {
  var popUrl = "Graph/seogu_Smoke_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function SmokepopupOpen_Jak() {
  var popUrl = "Graph/Jakjun_Smoke_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function SmokepopupOpen_Gim() {
  var popUrl = "Graph/Gimpo_Smoke_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}
function SmokepopupOpen_Song() {
  var popUrl = "Graph/Songdo_Smoke_graph.php"; //팝업창에 출력될 페이지 URL
  var popOption = "width=920, height=520, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
  window.open(popUrl, "", popOption);
}

function initMap() {
  var mapCanvus = document.getElementById("map");
  var mapOption = {center : {lat:37.6331,lng:126.7060}, zoom :9, disableDefaultUI: true};
  map = new google.maps.Map(mapCanvus,mapOption);

  heatmap = new google.maps.visualization.HeatmapLayer({
    data: getPoints(),
    map: map
  });
}

function toggleHeatmap() {
  heatmap.setMap(heatmap.getMap() ? null : map);
}

function getPoints() {
  return [
      <?php
        $current = strtotime($now);
        $query = "SELECT * FROM seogu_3data";
        $exec = mysqli_query($con,$query);
        while($row = mysqli_fetch_assoc($exec)) {
          $transtime = strtotime(($row['transtime']));
          $diff = $current - $transtime;
          if($diff<=1000){
            if(($row['smoke']!=0)||($row['co']>=100))
              echo "new google.maps.LatLng(".$row['latitude'].",".$row['longitude']."),";
          }
        }
      ?>
      <?php
        $current = strtotime($now);
        $query = "SELECT * FROM Jak_data";
        $exec = mysqli_query($con,$query);
        while($row = mysqli_fetch_assoc($exec)) {
          $transtime = strtotime(($row['transtime']));
          $diff = $current - $transtime;
          if($diff<=1000){
            if(($row['smoke']!=0)||($row['co']>=100))
              echo "new google.maps.LatLng(".$row['latitude'].",".$row['longitude']."),";
          }
        }
      ?>
      <?php
        $current = strtotime($now);
        $query = "SELECT * FROM gimpo_3data";
        $exec = mysqli_query($con,$query);
        while($row = mysqli_fetch_assoc($exec)) {
          $transtime = strtotime(($row['transtime']));
          $diff = $current - $transtime;
          if($diff<=1000){
            if(($row['smoke']!=0)||($row['co']>=100))
              echo "new google.maps.LatLng(".$row['latitude'].",".$row['longitude']."),";
          }
        }
      ?>
      <?php
        $fire=0;
        $current = strtotime($now);
        $query = "SELECT * FROM songdo_3data";
        $exec = mysqli_query($con,$query);
        while($row = mysqli_fetch_assoc($exec)) {
          $transtime = strtotime(($row['transtime']));
          $diff = $current - $transtime;
          if($diff<=1000){
            if(($row['smoke']!=0)||($row['co']>=100)){echo "new google.maps.LatLng(".$row['latitude'].",".$row['longitude']."),";
              $latitude=$row['latitude'];
              $longitude=$row['longitude'];
              $fire=1;
            }
          }
        }
        if($fire==1){
          $query_test = "UPDATE testwhere SET latitude=$latitude,longitude=$longitude";
          $exec = mysqli_query($con,$query_test);
        }
      ?>
  ];
}
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADZhjylXxCS2VvECDv1SAC2w5kFATvdVA&libraries=visualization&callback=initMap">
    </script>
  </body>
</html>
