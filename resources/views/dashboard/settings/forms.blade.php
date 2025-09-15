@extends('dashboard.base')

@section('content')

<div class="container-fluid">
            <div class="fade-in">
              <div class="row">

              <div class="col-sm-6">
                  <div class="card">
                    <div class="card-header"><strong>EIMCT</strong></div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <form action="/settings" method="POST" id="EIMCT_SUBSCRIPTION_PRICE">
                            @csrf
                          <input type="hidden" name="code" value="EIMCT_SUBSCRIPTION_PRICE"/>
                          <div class="form-group">
                            <label for="name">Frais de dossier (en FCFA)</label>
                            <input class="form-control" type="number" placeholder="montant" name="value" value="50000">
                          </div>
                          <div class="card-footer">
                              <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                          </div>
                          </form>

                          <form action="/settings" method="POST" id="EIMCT_ACOMPTE_PRICE">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_ACOMPTE_PRICE"/>
                              <div class="form-group">
                                <label for="name">Acompte sur scolarité (en FCFA)</label>
                                <input class="form-control"  type="number" placeholder="montant" name="value" value="100000">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>


                          <form action="/settings" method="POST" id="EIMCT_EMAIL_SUBSCRIPTION">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_EMAIL_SUBSCRIPTION"/>
                              <div class="form-group">
                                <label for="name">Email à envoyer à la réception d'un dossier d'admission</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIMCT_EMAIL_DOCUMENT">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_EMAIL_DOCUMENT"/>
                              <div class="form-group">
                                <label for="name">Email à envoyer contenant le documents et le certificat de scolarité</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                               </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIMCT_EMAIL_PAYMENT_REMINDER">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_EMAIL_PAYMENT_REMINDER"/>
                              <div class="form-group">
                                <label for="name">Email de rappel de paiement</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                               </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIMCT_SCHOOL_LINK">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_SCHOOL_LINK"/>
                              <div class="form-group">
                                <label for="name">Lien du site internet  de l'ecole</label>
                                <input class="form-control"  type="text" placeholder="lien" name="value" value="https://eimct.inter-nat.com">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIMCT_API_KEY">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_API_KEY"/>
                              <div class="form-group">
                                <label for="name">Clée API EIMCT</label>
                                <input class="form-control"  type="text" placeholder="key" name="value" value="">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>
                          <form action="/settings" method="POST" id="EIMCT_API_TOKEN">
                            @csrf
                              <input type="hidden" name="code" value="EIMCT_API_TOKEN"/>
                              <div class="form-group">
                                <label for="name">Clée API TOKEN EIMCT</label>
                                <input class="form-control"  type="text" placeholder="token" name="value" value="">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>


                        </div>
                      </div>

                      <!-- /.row-->
                    </div>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-header"><strong>EIEGI</strong></div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <form action="/settings" method="POST" id="EIEGI_SUBSCRIPTION_PRICE">
                            @csrf
                          <input type="hidden" name="code" value="EIEGI_SUBSCRIPTION_PRICE"/>
                          <div class="form-group">
                            <label for="name">Frais de dossier (en €)</label>
                            <input class="form-control" type="number" placeholder="montant" name="value" value="50">
                          </div>
                          <div class="card-footer">
                              <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                          </div>
                          </form>

                          <form action="/settings" method="POST" id="EIEGI_ACOMPTE_PRICE">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_ACOMPTE_PRICE"/>
                              <div class="form-group">
                                <label for="name">Acompte sur scolarité (en €)</label>
                                <input class="form-control"  type="number" placeholder="montant" name="value" value="1500">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>


                          <form action="/settings" method="POST" id="EIEGI_EMAIL_SUBSCRIPTION">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_EMAIL_SUBSCRIPTION"/>
                              <div class="form-group">
                                <label for="name">Email à envoyer à la réception d'un dossier d'admission</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIEGI_EMAIL_DOCUMENT">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_EMAIL_DOCUMENT"/>
                              <div class="form-group">
                                <label for="name">Email à envoyer contenant le documents et le certificat de scolarité</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                               </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>

                          <form action="/settings" method="POST" id="EIEGI_EMAIL_PAYMENT_REMINDER">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_EMAIL_PAYMENT_REMINDER"/>
                              <div class="form-group">
                                <label for="name">Email de rappel de paiement</label>
                                <select class="select form-control select2"  name="value"  >
                                  @foreach    ($templates as $template)
                                  <option value="{{$template->id}}">{{$template->name}}</option>
                                  @endforeach
                                </select>
                               </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>
                          <form action="/settings" method="POST" id="EIEGI_SCHOOL_LINK">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_SCHOOL_LINK"/>
                              <div class="form-group">
                                <label for="name">Lien du site internet  de l'ecole</label>
                                <input class="form-control"  type="text" placeholder="key" name="value" value="">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>
                          <form action="/settings" method="POST" id="EIEGI_API_KEY">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_API_KEY"/>
                              <div class="form-group">
                                <label for="name">Clée API EIEGI</label>
                                <input class="form-control"  type="text" placeholder="token" name="value" value="">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>
                          <form action="/settings" method="POST" id="EIEGI_API_TOKEN">
                            @csrf
                              <input type="hidden" name="code" value="EIEGI_API_TOKEN"/>
                              <div class="form-group">
                                <label for="name">Token API EIEGI</label>
                                <input class="form-control"  type="text" placeholder="lien" name="value" value="">
                              </div>
                              <div class="card-footer">
                                  <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                              </div>
                          </form>
                        </div>
                      </div>

                      <!-- /.row-->
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header"><strong>HUPEJUS</strong></div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <form action="/settings" method="POST" id="HUPEJUS_SUBSCRIPTION_PRICE">
                              @csrf
                            <input type="hidden" name="code" value="HUPEJUS_SUBSCRIPTION_PRICE"/>
                            <div class="form-group">
                              <label for="name">Frais de dossier (en FCFA)</label>
                              <input class="form-control" type="number" placeholder="montant" name="value" value="50000">
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                            </div>
                            </form>

                            <form action="/settings" method="POST" id="HUPEJUS_ACOMPTE_PRICE">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_ACOMPTE_PRICE"/>
                                <div class="form-group">
                                  <label for="name">Acompte sur scolarité (en FCFA)</label>
                                  <input class="form-control"  type="number" placeholder="montant" name="value" value="100000">
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>


                            <form action="/settings" method="POST" id="HUPEJUS_EMAIL_SUBSCRIPTION">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_EMAIL_SUBSCRIPTION"/>
                                <div class="form-group">
                                  <label for="name">Email à envoyer à la réception d'un dossier d'admission</label>
                                  <select class="select form-control select2"  name="value"  >
                                    @foreach    ($templates as $template)
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>

                            <form action="/settings" method="POST" id="HUPEJUS_EMAIL_DOCUMENT">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_EMAIL_DOCUMENT"/>
                                <div class="form-group">
                                  <label for="name">Email à envoyer contenant le documents et le certificat de scolarité</label>
                                  <select class="select form-control select2"  name="value"  >
                                    @foreach    ($templates as $template)
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                  </select>
                                 </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>

                            <form action="/settings" method="POST" id="HUPEJUS_EMAIL_PAYMENT_REMINDER">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_EMAIL_PAYMENT_REMINDER"/>
                                <div class="form-group">
                                  <label for="name">Email de rappel de paiement</label>
                                  <select class="select form-control select2"  name="value"  >
                                    @foreach    ($templates as $template)
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                  </select>
                                 </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>

                            <form action="/settings" method="POST" id="HUPEJUS_SCHOOL_LINK">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_SCHOOL_LINK"/>
                                <div class="form-group">
                                  <label for="name">Lien du site internet  de l'ecole</label>
                                  <input class="form-control"  type="text" placeholder="lien" name="value" value="https://hupejus.inter-nat.com">
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>

                            <form action="/settings" method="POST" id="HUPEJUS_API_KEY">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_API_KEY"/>
                                <div class="form-group">
                                  <label for="name">Clée API HPEJUS</label>
                                  <input class="form-control"  type="text" placeholder="key" name="value" value="">
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>
                            <form action="/settings" method="POST" id="HUPEJUS_API_TOKEN">
                              @csrf
                                <input type="hidden" name="code" value="HUPEJUS_API_TOKEN"/>
                                <div class="form-group">
                                  <label for="name">Clée API TOKEN HUPEJUS</label>
                                  <input class="form-control"  type="text" placeholder="token" name="value" value="">
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary  align-right" type="submit"> Enrregistrer</button>
                                </div>
                            </form>


                          </div>
                        </div>

                        <!-- /.row-->
                      </div>
                    </div>
                  </div>




              <!-- /.row-->

                <!-- /.col-->
              </div>
              <!-- /.row-->
            </div>
          </div>


@endsection
