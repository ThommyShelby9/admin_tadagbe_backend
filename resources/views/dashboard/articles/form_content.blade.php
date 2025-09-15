    <div class="form-group row">
        <label>Ecole</label>
        <select name="school_id" class="select2 form-controle" >
            <option value="EIMCT" {{isset($school_id)&&$school_id=="EIMCT"?'selected':''}}>EIMCT</option>
            <option value="EIEGI" {{isset($school_id)&&$school_id=="EIEGI"?'selected':''}}>EIEGI</option>
            <option value="HUPEJUS" {{isset($school_id)&&$school_id=="HUPEJUS"?'selected':''}}>HUPEJUS</option>
        </select>
        <input class="form-control" type="text" value="{{$article->title?? ''}}" placeholder="Titre" name="title" required autofocus/>
    </div>
    <div class="form-group row">
        <label>Titre</label>
        <input class="form-control" type="text" value="{{$article->title?? ''}}" placeholder="Titre" name="title" required autofocus/>
    </div>
    <div class="form-group row">
        <label>Sujet</label>
        <input class="form-control" id="subject" type="text" placeholder="Sujet"  value="{{$article->subject?? ''}}" name="subject" required/>
    </div>
    <label>Contenu</label>
    <input type="hidden" id="article_content" name="content" value=" {{$article->content?? ''}}">
    <div class="form-group row" id="content">

    </div>
    <div class="form-group ">
        <label>Image d'acceuil</label>
        <input class="form-control file" type="file" placeholder="Image" name="image1" value="{{$article->image1?$article->image1:""}}" required/>
    </div>
    <div class="form-group ">
        <label>Image de couverture</label>
        <input class="form-control file" type="file" placeholder="Image" name="image2" value="{{$article->image2?$article->image2:""}}" required/>
    </div>
    <div class="form-group ">
        <label>Image de couverture</label>
        <input class="form-control file" type="file" placeholder="Image" name="image3" value="{{$article->image3?$article->image3:""}}" required/>
    </div>
