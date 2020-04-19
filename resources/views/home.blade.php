@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script><!-- Bootstrap 4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

<div class="container">

  <div class="row">
     <div class="col-md-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>{{$usuarios->count()}}</h3>
                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            <a href="{{route('Usuarios.index')}}" class="small-box-footer">Administrar Usuarios <i class="fa fa-arrow-circle-right"></i></a>
            </div>
     </div>
     <div class="col-md-3 col-xs-6">
   <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
              <h3>{{$productos->count()}}</h3>

                <p>Productos en almacen</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
            <a href="{{route('Productos.index')}}" class="small-box-footer">Administrar Productos
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
    </div>
    <div class="col-md-3 col-xs-6">
   <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
              <h3>{{$categorias->count()}}</h3>

                <p>Categorias Registradas</p>
              </div>
              <div class="icon">
                <i class="fas fa-project-diagram"></i>
              </div>
            <a href="{{route('Categorias.index')}}" class="small-box-footer">Administrar Categorias <i class="fa fa-arrow-circle-right"></i></a>
            </div>
    </div>
    <div class="col-md-3 col-xs-6">
   <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
              <h3>{{$pedidos->count()}}</h3>

                <p>Pedidos pendientes</p>
              </div>
              <div class="icon">
                <i class="fas fa-balance-scale"></i>
              </div>
            <a href="{{route('Pedidos.index')}}" class="small-box-footer">Pedidos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-8">
    <canvas id="myChart"></canvas>
  </div>
  <div class="col-md-4">
    <div id='calendar'></div>
  </div>

  </div>

</div>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            defaultDate: '2014-09-12',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
        });
    });


    var ctx = document.getElementById('myChart').getContext('2d');
    var enero=20;
    var febrero=30;
    var marzo=10;
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45]
        },{

            label: 'Mi ejemplo',
            backgroundColor: 'blue',
            borderColor: 'blue',
            data: [enero,febrero,marzo,5,20,80,90]
        }

    ]
    },

    // Configuration options go here
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endsection
