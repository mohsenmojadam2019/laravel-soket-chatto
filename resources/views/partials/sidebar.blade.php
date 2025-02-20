<div id="profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="white">Twój profil</h3>
                <hr />
                <form id="profile-form" class="form-horizontal" role="form" v-on:submit.prevent='update()' enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="top-buffer">
                        <div class="fileinput {!! (\Auth::user()->photo) ? 'fileinput-exists' : 'fileinput-new' !!}" data-provides="fileinput">
                            <div class="fileinput-new thumbnail {{ (\Auth::user()->gender) ? 'female':'male' }}" data-trigger="fileinput"></div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                                @if (\Auth::user()->photo)
                                <img src="{!! 'photos/'.\Auth::user()->photo !!}" alt="Moje zdjęcie">
                                @endif
                            </div>
                            <div>
                                <span class="btn btn-primary btn-file pull-right">
                                    <span class="fileinput-new">Wybierz zdjęcie</span>
                                    <span class="fileinput-exists">Zmień zdjęcie</span>
                                    <input v-on:change="change()" type="file" name="photo">
                                </span>
                                <a href="#" v-on:click="change()" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Usuń</a>
                            </div>
                        </div>
                    </div>

                    <div class="top-buffer">
                        <div class="age-profile">
                            <div class="age-handle ui-slider-handle"></div>
                        </div>

                        <input name="age" value="{!! \Auth::user()->age !!}" type="text" class="age-input hidden" />
                    </div>

                    <div class="top-buffer-20">
                        <select name="region" v-on:change="change()" class="selectpicker form-control" data-style="btn-primary">
                            <option value=""> - moje województwo - </option>
                            <option {!! (\Auth::user()->region == 'Dolnośląskie') ? 'selected':'' !!}>Dolnośląskie</option>
                            <option {!! (\Auth::user()->region == 'Kujawsko-pomorskie') ? 'selected':'' !!}>Kujawsko-pomorskie</option>
                            <option {!! (\Auth::user()->region == 'Lubelskie') ? 'selected':'' !!}>Lubelskie</option>
                            <option {!! (\Auth::user()->region == 'Lubuskie') ? 'selected':'' !!}>Lubuskie</option>
                            <option {!! (\Auth::user()->region == 'Łódzkie') ? 'selected':'' !!}>Łódzkie</option>
                            <option {!! (\Auth::user()->region == 'Małopolskie') ? 'selected':'' !!}>Małopolskie</option>
                            <option {!! (\Auth::user()->region == 'Mazowieckie') ? 'selected':'' !!}>Mazowieckie</option>
                            <option {!! (\Auth::user()->region == 'Opolskie') ? 'selected':'' !!}>Opolskie</option>
                            <option {!! (\Auth::user()->region == 'Podkarpackie') ? 'selected':'' !!}>Podkarpackie</option>
                            <option {!! (\Auth::user()->region == 'Podlaskie') ? 'selected':'' !!}>Podlaskie</option>
                            <option {!! (\Auth::user()->region == 'Pomorskie') ? 'selected':'' !!}>Pomorskie</option>
                            <option {!! (\Auth::user()->region == 'Śląskie') ? 'selected':'' !!}>Śląskie</option>
                            <option {!! (\Auth::user()->region == 'Świętokrzyskie') ? 'selected':'' !!}>Świętokrzyskie</option>
                            <option {!! (\Auth::user()->region == 'Warmińsko-mazurskie') ? 'selected':'' !!}>Warmińsko-mazurskie</option>
                            <option {!! (\Auth::user()->region == 'Wielkopolskie') ? 'selected':'' !!}>Wielkopolskie</option>
                            <option {!! (\Auth::user()->region == 'Zachodniopomorskie') ? 'selected':'' !!}>Zachodniopomorskie</option>
                        </select>
                    </div>

                    <div class="top-buffer">
                        <select name="interests[]" v-on:change="change()" class="selectpicker form-control"
                                multiple
                                data-selected-text-format="count"
                                data-count-selected-text="Wybrane cele: {0}"
                                data-style="btn-primary"
                                data-none-selected-text=" - poszukuję - ">
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Luźnej rozmowy', \Auth::user()->interests)) ? 'selected':'' !!}>Luźnej rozmowy</option>
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Spotkania', \Auth::user()->interests)) ? 'selected':'' !!}>Spotkania</option>
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Związku', \Auth::user()->interests)) ? 'selected':'' !!}>Związku</option>
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Przyjaźni', \Auth::user()->interests)) ? 'selected':'' !!}>Przyjaźni</option>
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Przygody', \Auth::user()->interests)) ? 'selected':'' !!}>Przygody</option>
                            <option {!! (is_array(\Auth::user()->interests) && in_array('Niczego', \Auth::user()->interests)) ? 'selected':'' !!}>Niczego</option>
                        </select>
                    </div>

                    <div class="top-buffer">
                        <textarea
                            name="about" v-on:keyup="change()"
                            data-msg-maxlength="Opis nie może być dłuższy niż 200 znaków."
                            data-rule-maxlength="200"
                            maxlength="200"
                            class="form-control profile-description" rows="5" placeholder="Opisz się w kilku słowach...">{!! \Auth::user()->about !!}</textarea>
                    </div>

                    <div class="top-buffer"></div>
                </form>
            </div>
        </div>
        @if (!\Auth::user()->reserved)
            <hr class="delAfterAlert" />
            <div class="row">
                <div class="col-md-12">
                    <div class="reserving" v-if="!reserved">
                        <form class="form-horizontal" role="reserve" v-on:submit.prevent='reserve($event)'>
                            <div class="top-buffer">
                                <input type="password" class="form-control" name="password" required data-msg-minlength="Hasło musi mieć minimum 4 znaki."
                                       data-rule-minlength="4" placeholder="Hasło rezerwacji" />
                            </div>
                            <div class="top-buffer">
                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save fa-fw"></i> Zarezerwuj nick</button>
                            </div>
                        </form>
                    </div>
                    <div class="alert alert-success" v-else>
                        <strong>Zarezerwowano!</strong> Od teraz Twój nick jest zajęty pod tym hasłem.
                    </div>
                </div>
            </div>
        @endif
        <div class="top-buffer">
            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default btn-block"><i class="fa fa-sign-out fa-fw"></i></button>
            </form>
        </div>
        <div class="top-buffer"></div>
    </div>
</div>