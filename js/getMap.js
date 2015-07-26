//Google Mapsのプログラムを実行する
//地図表示関数
function googleMapsSyncer(lat,lng){
    //キャンパスの要素を取得する
    var canvas = document.getElementById( "map-canvas" );
    //中心の位置座標を指定する
    var latlng = new google.maps.LatLng( lat,lng );
    //地図のオプションを設定する
    var mapOptions = {
	zoom: 15 ,				//ズーム値
	center: latlng ,		//中心座標 [latlng]
};

    //[canvas]に、[mapOptions]の内容の、地図のインスタンス([map])を作成する
    var map = new google.maps.Map( canvas , mapOptions );

    var marker = new google.maps.Marker({
    	position: latlng
    });
    marker.setMap(map);
}

function getCELL() {
	var myTbl = document.getElementById('TBL');
    // trをループ。rowsコレクションで,行位置取得。
    　for (var i=1; i<myTbl.rows.length; i++) {
        // tr内のtdをループ。cellsコレクションで行内セル位置取得。
        // onclickで 'Mclk'を実行。
        //thisはクリックしたセル"td"のオブジェクトを返す。
        //i番行の1番列のセルのみクリック可能に
        var Cells=myTbl.rows[i].cells[1]; 
        Cells.onclick =function(){Mclk(this);}
    　 }
　}
function Mclk(Cell) { 
	var res = '郵便番号：'+Cell.innerHTML;
	getGeo(Cell.innerHTML);
	document.getElementById('Mbox0').innerHTML=res;
	var Ms1=document.getElementById('Mbox1')
	Ms1.innerText=Cell.innerHTML;
	Ms1.textContent=Cell.innerHTML;
}
// try ～ catch 例外処理、エラー処理
// イベントリスナーaddEventListener,attachEventメソッド
try{
	window.addEventListener("load",getCELL,false);
}catch(e){
	window.attachEvent("onload",getCELL);
}


//引数の郵便番号から緯度経度を求めて、地図表示関数を呼び出す
function getGeo(zipcode){
	zipcode = zipcode.replace(/-/g,"");//'-'削除
	var getRecent = "http://maps.googleapis.com/maps/api/geocode/json?address="+zipcode+"&language=ja&sensor=false";

	$.getJSON(getRecent,function(json){
		var lat = json.results[0].geometry.location.lat;
		var lng = json.results[0].geometry.location.lng;  
		//var res = ""+lat+","+lng;
        //alert(res);
        googleMapsSyncer(lat,lng);

    });
}
