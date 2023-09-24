<strong style="font-size: 18px;"> Handover car record </strong>
<div style="height: 20px;"></div>


<div class="form-group row">
    <label class="col-md-3 col-form-label"> Date </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HandedOverDate | date : 'dd MMM yyyy']]</div>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Time </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HandedOverTime || '-']]</div>
    </div>
  </div>


  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Place </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HandedOverDescription || '-']]</div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3 col-form-label"> Description </label>
    <div class="col-md-9">
      <div class="text-view"> [[dataView.HandedOverPlace || '-']]</div>
    </div>
  </div>


