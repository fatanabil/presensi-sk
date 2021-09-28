$(document).ready(function(){
    let base_url = 'http://localhost:8080'
    var g_tglAwal = ''
    var g_tglAkhir = ''
    var search = ''
    var kelas = $('#kelas').text()
    var smt = 'all'

    $('#toggle-date').click(function(){
        $('.tanggal').prop('disabled', function (_, val){
            return !val
        })
    })

    $('#semester-select').change(function(){
        var smt = 'ganjil'
        smt = $(this).children("option:selected").val()
        $.ajax({
            url : base_url+'/user/livesearchsmt',
            method : "POST",
            data : {semester : smt},
            success : function(data){
                $('#result').html(data)
            }
        })

        $('#pdf').attr('href', base_url+'/rekap-pdf/'+kelas+'/'+smt)
    })

    function loadData(keyword, tglAwal, tglAkhir){
        $.ajax({
            url : base_url+"/user/livesearchsis",
            method : "POST",
            data : {nama : keyword,
                    tglAwal : tglAwal,
                    tglAkhir : tglAkhir},
            success : function(data){
                $('#result-cari').html(data)
            }
        })
    }

    if(new Date(g_tglAwal).getTime > new Date(g_tglAkhir).getTime){
        var pesan = 'Tanggal Awal lebih besar dari tanggal akhir'

        console.log(pesan)
        $.ajax({
            url : base_url+"/user/livesearchsis",
            method : "POST",
            data : {pesan : pesan}
        })
    }

    $('#keyword').keyup(function(){
        search = $(this).val()

        if( search != '' && g_tglAwal != '' && g_tglAkhir != ''){
            loadData(search, g_tglAwal, g_tglAkhir)
        } else{
            if(search != ''){
                loadData(search, g_tglAwal, g_tglAkhir)
            } else{
                if(search == ''){
                    loadData('', g_tglAwal, g_tglAkhir);
                } else{
                    loadData();
                }
            }
        }
    })

    $('#tgl-awal').change(function(){
        var tglAwal = $(this).val()
        g_tglAwal = tglAwal

        if(search != ''){
            loadData(search, g_tglAwal, g_tglAkhir);
        } else{
            if(search == ''){
                loadData('', g_tglAwal, g_tglAkhir)
            } else{
                loadData();
            }
        }
    })
    
    $('#tgl-akhir').change(function(){
        var tglAkhir = $(this).val()
        g_tglAkhir = tglAkhir

        if(search != ''){
            loadData(search, g_tglAwal, g_tglAkhir);
        } else{
            if(search == ''){
                loadData('', g_tglAwal, g_tglAkhir)
            } else{
                loadData();
            }
        }
    })
})