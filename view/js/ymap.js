var myMap;

ymaps.ready(init);

function init () {
    myMap = new ymaps.Map("map", {
        center: [43.50, 39.88],
        zoom: 12,
        controls: ['zoomControl', 'searchControl','geolocationControl','trafficControl']
    }, {
        searchControlProvider: 'yandex#search'
    });
    getMarks();

    var btn_new_post = new ymaps.control.Button({
        data: {
            image: 'img/icon/plus.png',
            content: 'Добавить пост ДПС',
            title: 'Добавить новый пост ДПС'
        },
        options: {
            selectOnClick: true,
            maxWidth: [30, 170, 200],
            float: 'right',
            floatIndex: 1
        }
    });
    /*var new_post = new ymaps.Placemark(myMap.getCenter(), {
        balloonContent: 'Новый пост'
    }, {
        preset: 'islands#dotIcon',
        iconColor: '#735184',
        draggable: true
    });*/
    btn_new_post.events.add('click', function () {
        console.log('Add post')
    });
    myMap.controls.add(btn_new_post);
}

function getMarks(){
    myMap.geoObjects.removeAll();
    $.ajax({
        url: '/dev/dev/getMarks',
        dataType: 'json',
        success: function(data){
            for (var i=0; i<data.length; i++) {
                Placemark = new ymaps.Placemark([data[i].x, data[i].y], {
                    // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
                    balloonContentHeader: data[i].header,
                    balloonContentBody: data[i].description,
                    balloonContentFooter: data[i].footer,
                    hintContent: data[i].hint,
                },{
                    iconLayout: 'default#imageWithContent',
                    iconImageHref: 'img/icon/car.png',
                    iconImageSize: [32, 32],
                    iconImageOffset: [-16, -16]
                });
                myMap.geoObjects.add(Placemark);
            }
        },
        error: function (xhr, textStatus, errorThrown){
            alert('Ошибка: ' + textStatus+' '+errorThrown);
        }
    });
}