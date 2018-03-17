<link rel="stylesheet" href="res/calendar/css/calendar.min.css">

<div class="row">
    <div class="col-md-12 col-xs-11">
        <div class="page-header">
            <div class="pull-right form-inline">
                <div class="btn-group">
                    <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                    <button class="btn btn-default" data-calendar-nav="today">Hoy</button>
                    <button class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-info" data-calendar-view="year">Año</button>
                    <button class="btn btn-info active" data-calendar-view="month">Mes</button>
                    <button class="btn btn-info" data-calendar-view="week">Semana</button>
                    <button class="btn btn-info" data-calendar-view="day">Día</button>
                </div>
            </div>
            <h3></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-11 col-xs-11 pull-right">
        <div id="calendar"></div>
    </div>
</div>

<div class="modal fade" id="events-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Detalles</h3>
            </div>
            <div class="modal-body" style="min-height: 345px"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="res/calendar/components/underscore/underscore-min.js"></script>
<script type="text/javascript" src="res/calendar/components/jstimezonedetect/jstz.min.js"></script>
<script type="text/javascript" src="res/calendar/js/language/es-ES.js"></script>
<script type="text/javascript" src="res/calendar/js/calendar.js"></script>
<script type="text/javascript" src="res/calendar/js/app.js"></script>