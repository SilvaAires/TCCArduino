const HOME = '/Irrigacao_Autonoma/';

function selectPerfil(){
    $.ajax({
		url: HOME + 'controller/selectExibePerfil',
        method: 'post',
        success: function (response) {
            $("#pasteHere").html(response);
        }
    });
}

function selectRegistroLogin(){
    $.ajax({
		url: HOME + 'controller/selectRegistroLogin',
        method: 'post',
        success: function (response) {
            $("#pasteHere2").html(response);
        }
    });
}

function AnotacaoAjax(){
    $.ajax({
		url: HOME + 'controller/selectAnotacaoAjax',
        method: 'post',
        success: function (response) {
            console.log(response);
            $("#pasteHere").html(response);
        }
    });
}

$("#btnBuscarTodos").click(function () {
    var valorSelecionado = $("#combobox").val();
    console.log("Valor selecionado: " + valorSelecionado);
    $.ajax({
		url: HOME + 'controller/selectTodos',
        method: 'post',
        data: {
            combobox: $("#combobox").val()
        },
        success: function (response) {
            console.log(response);
            $("#pasteHere").html(response);
        }
    });
});

$("#btnProcurar").click(function () {
    $.ajax({
		url: HOME + 'controller/selectTodosPesquisa',
        method: 'post',
        data: {
            diaInicio: $("#diaInicio").val(),
            diaFinal: $("#diaFinal").val(),
            horaInicio: $("#horaInicio").val(),
            horaFinal: $("#horaFinal").val(),
            combobox: $("#combobox").val()
        },
        success: function (response) {
            console.log(response);
            $("#pasteHere").html(response);
        }
    });
});

$("#btnLogar").click(function () {
    $.ajax({
		url: HOME + 'controller/selectValidacaoLogin',
        method: 'post',
        data: {
            login: $("#login").val(),
            senha: $("#senha").val()
        },
        success: function (response) {
            var boolean = JSON.parse(response);
            if(boolean){
                window.location.href = HOME + 'Home';
            }else{
                $("#mensagemErro").text('Apelido ou senha incorretos.');
            }
        }
    });
});

function editarDados(){
    $.ajax({
		url: HOME + 'controller/updateUser',
        method: 'post',
        data: {
            idUser: $("#idUser").val(),
            usuario: $("#usuario").val(),
            senha: $("#senha").val(),
            cargo: $("#cargo").val(),
            email: $("#email").val(),
            telefone: $("#telefone").val()
        },
        success: function (response) {
            var bool = JSON.parse(response);
            if (bool === true) {
                alert("Alterado!");
                console.log("Alterado");
            } else {
                alert("Errrrrrrrrooooo!");
                console.log("Errrrrrrrrooooo");
            }
        }
    });
}

function excluirConta(){
    $.ajax({
		url: HOME + 'controller/deleteUser',
        method: 'post',
        data: {
            idUser: $("#idUser").val()
        },
        success: function (response) {
            var bool = JSON.parse(response);
            if (bool === true) {
                window.location.href = HOME + 'Login';
                alert("Excluido!");
                console.log("Excluido");
            } else {
                alert("Errrrrrrrrooooo!");
                console.log("Errrrrrrrrooooo");
            }
        }
    });
}

function uploadFile(){
	if($("#file_to_upload").val() != ""){
        var file_data = $('#file_to_upload').prop('files')[0];
        var form_data = new FormData();

        form_data.append('file', file_data);
        form_data.append('idDado', $("#idDado").val());
        form_data.append('descricao', $("#descricao").val());

        $.ajax({
            url: HOME + 'controller/insertAnotacaoAjax', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                var bool = JSON.parse(data);
                if (bool === true) {
                    window.location.href = HOME + 'Home';
                    // clear file field
                    $("#file_to_upload").val("");
                } else {
                    console.log("Errrrrrrrrooooo");
                    // clear file field
                    $("#file_to_upload").val("");
                }
            }
        });
    }
    else{
        alert("Please select file!");
    }
}

$("#btnCadastrar").click(function () {
    $.ajax({
		url: HOME + 'controller/insertUserAjax',
        method: 'post',
        data: {
            usuario: $("#usuario").val(),
            senha: $("#senha").val(),
            cargo: $("#cargo").val(),
            email: $("#email").val(),
            telefone: $("#telefone").val()
        },
        success: function (response) {
            var boolean = JSON.parse(response);
            if(boolean){
                window.location.href = HOME + 'Home';
            }else{
                $("#mensagemErro").text('Apelido ou senha incorretos.');
            }
        }
    });
});

function anotacao(IdDado) {
	window.location.href = HOME + 'Anotacao/' + IdDado;
}

let chartUmidDoAr;
let chartPorUmidSolo;

$("#btnGraficoAll").click(function () {
    $.ajax({
		url: HOME + 'controller/selectDadosGraficos',
        method: 'post',
        success: function (response) {
            console.log("Raw response:", response);
            try {
                const data = JSON.parse(response);
                console.log("Parsed data:", data);
                if(data.length > 0){
                    const IdDado = data.map(entry => entry.IdDado);
                    const IdenEsp = data.map(entry => entry.IdenEsp);
                    const TempDoAr = data.map(entry => entry.TempDoAr);
                    const UmidDoAr = data.map(entry => entry.UmidDoAr);
                    const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                    const UmidSolo = data.map(entry => entry.UmidSolo);
                    const DataCaptura = data.map(entry => entry.DataCaptura);
                    const HoraCaptura = data.map(entry => entry.HoraCaptura);

                    if(chartUmidDoAr) {
                        chartUmidDoAr.destroy();
                    }
                    
                    const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                    chartUmidDoAr = new Chart(ctxUmidDoAr, {
                        type: 'line',
                        data: {
                            labels: DataCaptura,
                            datasets: [{
                                label: 'Umidade do Ar (%)',
                                data: UmidDoAr,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
                                tension: 0.1
                            },
                            {
                                label: 'Temperatura do Ar (°C)',
                                data: TempDoAr,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Data de Captura'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Temperatura e Umidade do Ar'
                                    }
                                }
                            }
                        }
                    });

                    if(chartPorUmidSolo) {
                        chartPorUmidSolo.destroy();
                    }
                    
                    const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                    chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                        type: 'line',
                        data: {
                            labels: DataCaptura,
                            datasets: [{
                                label: 'Umidade do Solo (%)',
                                data: PorUmidSolo,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Data de Captura'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Umidade do Solo (%)'
                                    }
                                }
                            }
                        }
                    });
                }else {
                    console.log('No data available to plot the charts.');
                }
            } catch (error) {
                console.error('Failed to parse JSON response:', error);
            }
        }
    });
});

$("#btnDiaGrafico").click(function () {
    console.log("Ola");
    $.ajax({
		url: HOME + 'controller/selectDadosGraficosData',
        method: 'post',
        data: {
            diaInicioG: $("#diaInicioG").val(),
            diaFinalG: $("#diaFinalG").val(),
            horaInicioG: $("#horaInicioG").val(),
            horaFinalG: $("#horaFinalG").val()
        },
        success: function (response) {
            console.log("Raw response:", response);
            try {
                const data = JSON.parse(response);
                console.log("Parsed data:", data);
                if(data.length > 0){
                    const IdDado = data.map(entry => entry.IdDado);
                    const IdenEsp = data.map(entry => entry.IdenEsp);
                    const TempDoAr = data.map(entry => entry.TempDoAr);
                    const UmidDoAr = data.map(entry => entry.UmidDoAr);
                    const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                    const UmidSolo = data.map(entry => entry.UmidSolo);
                    const DataCaptura = data.map(entry => entry.DataCaptura);
                    const HoraCaptura = data.map(entry => entry.HoraCaptura);

                    if(chartUmidDoAr) {
                        chartUmidDoAr.destroy();
                    }
                    
                    const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                    chartUmidDoAr = new Chart(ctxUmidDoAr, {
                        type: 'line',
                        data: {
                            labels: DataCaptura,
                            datasets: [{
                                label: 'Umidade do Ar (%)',
                                data: UmidDoAr,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
                                tension: 0.1
                            },
                            {
                                label: 'Temperatura do Ar (°C)',
                                data: TempDoAr,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Data de Captura'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Temperatura e Umidade do Ar'
                                    }
                                }
                            }
                        }
                    });

                    if(chartPorUmidSolo) {
                        chartPorUmidSolo.destroy();
                    }
                    
                    const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                    chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                        type: 'line',
                        data: {
                            labels: DataCaptura,
                            datasets: [{
                                label: 'Umidade do Solo (%)',
                                data: PorUmidSolo,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Data de Captura'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Umidade do Solo (%)'
                                    }
                                }
                            }
                        }
                    });
                }else {
                    console.log('No data available to plot the charts.');
                }
            } catch (error) {
                console.error('Failed to parse JSON response:', error);
            }
        }
    });
});

$("#btnBuscarGrafico").click(function () {
    const inputElement = document.getElementById('combobox'); 
    const valor = inputElement.value; 
    
    if(valor == 'selectMaiorTemp'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.MaiorTemperatura);
                        const UmidDoAr = data.map(entry => entry.UmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
    if(valor == 'selectMenorTemp'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.MenorTemperatura);
                        const UmidDoAr = data.map(entry => entry.UmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
    if(valor == 'selectMaiorUmid'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.TempDoAr);
                        const UmidDoAr = data.map(entry => entry.MaiorUmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
    if(valor == 'selectMenorUmid'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.TempDoAr);
                        const UmidDoAr = data.map(entry => entry.MenorUmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.PorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
    if(valor == 'selectMaiorUmidSolo'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.TempDoAr);
                        const UmidDoAr = data.map(entry => entry.UmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.MaiorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
    if(valor == 'selectMenorUmidSolo'){
        console.log(valor);
        $.ajax({
            url: HOME + 'controller/' + valor,
            method: 'post',
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if(data.length > 0){
                        const TempDoAr = data.map(entry => entry.TempDoAr);
                        const UmidDoAr = data.map(entry => entry.UmidDoAr);
                        const PorUmidSolo = data.map(entry => entry.MenorUmidSolo);
                        const UmidSolo = data.map(entry => entry.UmidSolo);
                        const DataCaptura = data.map(entry => entry.MesAno);
                        const HoraCaptura = data.map(entry => entry.HoraCaptura);

                        if(chartUmidDoAr) {
                            chartUmidDoAr.destroy();
                        }
                        
                        const ctxUmidDoAr = document.getElementById('chartUmidDoAr').getContext('2d');
                        chartUmidDoAr = new Chart(ctxUmidDoAr, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Ar (%)',
                                    data: UmidDoAr,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                },
                                {
                                    label: 'Temperatura do Ar (°C)',
                                    data: TempDoAr,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Temperatura e Umidade do Ar'
                                        }
                                    }
                                }
                            }
                        });

                        if(chartPorUmidSolo) {
                            chartPorUmidSolo.destroy();
                        }
    
                        const ctxPorUmidSolo = document.getElementById('chartPorUmidSolo').getContext('2d');
                        chartPorUmidSolo = new Chart(ctxPorUmidSolo, {
                            type: 'line',
                            data: {
                                labels: DataCaptura,
                                datasets: [{
                                    label: 'Umidade do Solo (%)',
                                    data: PorUmidSolo,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Data de Captura'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Umidade do Solo (%)'
                                        }
                                    }
                                }
                            }
                        });
                    }else {
                        console.log('No data available to plot the charts.');
                    }
                } catch (error) {
                    console.error('Failed to parse JSON response:', error);
                }
            }
        });
    }
});


/*$("#formulario").submit(function() {
    var formData = new FormData(this);
    console.log("oi");
    $.ajax({
        url: HOME + 'controller/insertAnotacaoAjax',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            var boolean = JSON.parse(response);
            if (boolean) {
                window.location.href = HOME + 'Home';
            } else {
                console.log("Errrrrrrrrooooo");
                $("#mensagemErro").text('Apelido ou senha incorretos.');
            }
        }
    });
});

/*$("#btnTESTE").click(function (event) {
    event.preventDefault(); 
    console.log("EnTROU AQUI");
    // Cria um objeto FormData
    var formData = new FormData($("#anotacaoForm")[0]);
    
    /* Adiciona os campos ao FormData
    formData.append('idDado', $("#idDado").val());
    formData.append('descricao', $("#descricao").val());
    formData.append('imagem', $('#imagem')[0].files[0]); // Acessa o arquivo diretamente

    $.ajax({
        url: HOME + 'controller/insertUserAjax',
        method: 'post',
        data: formData,
        processData: false, // Impede o jQuery de transformar o FormData em string
        contentType: false, // Deixe o jQuery definir o tipo correto do conteúdo
        success: function (response) {
            var boolean = JSON.parse(response);
            if (boolean) {
                window.location.href = HOME + 'Home';
            } else {
                console.log("Errrrrrrrrooooo");
                $("#mensagemErro").text('Apelido ou senha incorretos.');
            }
        }
    });
});*/