<x-app-layout>
    <x-slot name="header">
        <div class="card-content card-dark py-3 px-4 mb-5">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item text-white active" aria-current="page">
                    {{ __('People Partner') }}
                </li>
            </ol>
        </div>
    </x-slot>

    <div class="row mb-5">
        <div class="col-3">
            <form data-filter-form="people-partner" action="{{ route('ajax-stats-parser') }}" method="post">
                @csrf
                @method('POST')

                <h2>Filters</h2>
                <h4 class="mt-5">Specialization</h4>
                <div class="d-flex flex-wrap gap-1">
                    <input class="btn-check" type="radio" data-filter-default name="title" id="title-1" value="" autocomplete="off" required checked>
                    <label for="title-1" class="btn btn-sm btn-outline-primary">Any</label>

                    <input class="btn-check" type="radio" name="title" id="title-2" value="JavaScript" autocomplete="off" required>
                    <label for="title-2" class="btn btn-sm btn-outline-primary">JavaScript / Front-End</label>

                    <input class="btn-check" type="radio" name="title" id="title-3" value="Java" autocomplete="off" required>
                    <label for="title-3" class="btn btn-sm btn-outline-primary">Java</label>

                    <input class="btn-check" type="radio" name="title" id="title-4" value=".NET" autocomplete="off" required>
                    <label for="title-4" class="btn btn-sm btn-outline-primary">C# / .NET</label>

                    <input class="btn-check" type="radio" name="title" id="title-5" value="Python" autocomplete="off" required>
                    <label for="title-5" class="btn btn-sm btn-outline-primary">Python</label>

                    <input class="btn-check" type="radio" name="title" id="title-6" value="PHP" autocomplete="off" required>
                    <label for="title-6" class="btn btn-sm btn-outline-primary">PHP</label>

                    <input class="btn-check" type="radio" name="title" id="title-7" value="Node.js" autocomplete="off" required>
                    <label for="title-7" class="btn btn-sm btn-outline-primary">Node.js</label>

                    <input class="btn-check" type="radio" name="title" id="title-8" value="iOS" autocomplete="off" required>
                    <label for="title-8" class="btn btn-sm btn-outline-primary">iOS</label>

                    <input class="btn-check" type="radio" name="title" id="title-9" value="Android" autocomplete="off" required>
                    <label for="title-9" class="btn btn-sm btn-outline-primary">Android</label>

                    <input class="btn-check" type="radio" name="title" id="title-10" value="C++" autocomplete="off" required>
                    <label for="title-10" class="btn btn-sm btn-outline-primary">C++</label>

                    <input class="btn-check" type="radio" name="title" id="title-11" value="Flutter" autocomplete="off" required>
                    <label for="title-11" class="btn btn-sm btn-outline-primary">Flutter</label>

                    <input class="btn-check" type="radio" name="title" id="title-12" value="Golang" autocomplete="off" required>
                    <label for="title-12" class="btn btn-sm btn-outline-primary">Golang</label>

                    <input class="btn-check" type="radio" name="title" id="title-13" value="Ruby" autocomplete="off" required>
                    <label for="title-13" class="btn btn-sm btn-outline-primary">Ruby</label>

                    <input class="btn-check" type="radio" name="title" id="title-14" value="Scala" autocomplete="off" required>
                    <label for="title-14" class="btn btn-sm btn-outline-primary">Scala</label>

                    <input class="btn-check" type="radio" name="title" id="title-15" value="Salesforce" autocomplete="off" required>
                    <label for="title-15" class="btn btn-sm btn-outline-primary">Salesforce</label>

                    <input class="btn-check" type="radio" name="title" id="title-16" value="Rust" autocomplete="off" required>
                    <label for="title-16" class="btn btn-sm btn-outline-primary">Rust</label>
                </div>

                <h4 class="mt-5">Work experience</h4>
                <div class="d-flex flex-wrap gap-1">
                    <input class="btn-check" type="radio" data-filter-default name="exp" id="exp-1" value="" autocomplete="off" required checked>
                    <label for="exp-1" class="btn btn-sm btn-outline-primary">Any</label>

                    <input class="btn-check" type="radio" name="exp" id="exp-2" value="0" autocomplete="off" required>
                    <label for="exp-2" class="btn btn-sm btn-outline-primary">Less then 1 year</label>

                    <input class="btn-check" type="radio" name="exp" id="exp-3" value="1" autocomplete="off" required>
                    <label for="exp-3" class="btn btn-sm btn-outline-primary">1-2 years</label>

                    <input class="btn-check" type="radio" name="exp" id="exp-4" value="2" autocomplete="off" required>
                    <label for="exp-4" class="btn btn-sm btn-outline-primary">2-3 years</label>

                    <input class="btn-check" type="radio" name="exp" id="exp-5" value="3" autocomplete="off" required>
                    <label for="exp-5" class="btn btn-sm btn-outline-primary">3-5 years</label>

                    <input class="btn-check" type="radio" name="exp" id="exp-6" value="4" autocomplete="off" required>
                    <label for="exp-6" class="btn btn-sm btn-outline-primary">More than 5 years</label>
                </div>

                <h4 class="mt-5">Grade</h4>
                <div class="d-flex flex-wrap gap-1">
                    <input class="btn-check" type="radio" data-filter-default name="grade" id="grade-1" value="" autocomplete="off" required checked>
                    <label for="grade-1" class="btn btn-sm btn-outline-primary">Any</label>

                    <input class="btn-check" type="radio" name="grade" id="grade-2" value="trainee" autocomplete="off" required>
                    <label for="grade-2" class="btn btn-sm btn-outline-primary">Intern/Trainee</label>

                    <input class="btn-check" type="radio" name="grade" id="grade-3" value="junior" autocomplete="off" required>
                    <label for="grade-3" class="btn btn-sm btn-outline-primary">Junior</label>

                    <input class="btn-check" type="radio" name="grade" id="grade-4" value="middle" autocomplete="off" required>
                    <label for="grade-4" class="btn btn-sm btn-outline-primary">Middle</label>

                    <input class="btn-check" type="radio" name="grade" id="grade-5" value="senior" autocomplete="off" required>
                    <label for="grade-5" class="btn btn-sm btn-outline-primary">Senior</label>
                </div>

                <h4 class="mt-5">English level</h4>
                <div class="d-flex flex-wrap gap-1">
                    <input class="btn-check" type="radio" data-filter-default name="english" id="english-1" value="" autocomplete="off" required checked>
                    <label for="english-1" class="btn btn-sm btn-outline-primary">Any</label>

                    <input class="btn-check" type="radio" name="english" id="english-2" value="no_english" autocomplete="off" required>
                    <label for="english-2" class="btn btn-sm btn-outline-primary">No English</label>

                    <input class="btn-check" type="radio" name="english" id="english-3" value="basic" autocomplete="off" required>
                    <label for="english-3" class="btn btn-sm btn-outline-primary">Beginner/Elementary</label>

                    <input class="btn-check" type="radio" name="english" id="english-4" value="pre" autocomplete="off" required>
                    <label for="english-4" class="btn btn-sm btn-outline-primary">Pre-Intermediate</label>

                    <input class="btn-check" type="radio" name="english" id="english-5" value="intermediate" autocomplete="off" required>
                    <label for="english-5" class="btn btn-sm btn-outline-primary">Intermediate</label>

                    <input class="btn-check" type="radio" name="english" id="english-6" value="upper" autocomplete="off" required>
                    <label for="english-6" class="btn btn-sm btn-outline-primary">Upper-Intermediate</label>

                    <input class="btn-check" type="radio" name="english" id="english-7" value="fluent" autocomplete="off" required>
                    <label for="english-7" class="btn btn-sm btn-outline-primary">Advanced/Fluent</label>
                </div>

                <h4 class="mt-5">City</h4>
                <div class="d-flex flex-wrap gap-1">
                    <input class="btn-check" type="radio" data-filter-default name="location" id="location-1" value="" autocomplete="off" required checked>
                    <label for="location-1" class="btn btn-sm btn-outline-primary">Any</label>

                    <input class="btn-check" type="radio" name="location" id="location-2" value="kyiv" autocomplete="off" required>
                    <label for="location-2" class="btn btn-sm btn-outline-primary">Київ</label>

                    <input class="btn-check" type="radio" name="location" id="location-3" value="vinnytsia" autocomplete="off" required>
                    <label for="location-3" class="btn btn-sm btn-outline-primary">Вінниця</label>

                    <input class="btn-check" type="radio" name="location" id="location-4" value="dnipro" autocomplete="off" required>
                    <label for="location-4" class="btn btn-sm btn-outline-primary">Дніпро</label>

                    <input class="btn-check" type="radio" name="location" id="location-5" value="ivano-frankivsk" autocomplete="off" required>
                    <label for="location-5" class="btn btn-sm btn-outline-primary">Івано-Франківськ</label>

                    <input class="btn-check" type="radio" name="location" id="location-6" value="zhytomyr" autocomplete="off" required>
                    <label for="location-6" class="btn btn-sm btn-outline-primary">Житомир</label>

                    <input class="btn-check" type="radio" name="location" id="location-7" value="zaporizhzhia" autocomplete="off" required>
                    <label for="location-7" class="btn btn-sm btn-outline-primary">Запоріжжя</label>

                    <input class="btn-check" type="radio" name="location" id="location-8" value="lviv" autocomplete="off" required>
                    <label for="location-8" class="btn btn-sm btn-outline-primary">Львів</label>

                    <input class="btn-check" type="radio" name="location" id="location-9" value="mykolaiv" autocomplete="off" required>
                    <label for="location-9" class="btn btn-sm btn-outline-primary">Миколаїв</label>

                    <input class="btn-check" type="radio" name="location" id="location-10" value="odesa" autocomplete="off" required>
                    <label for="location-10" class="btn btn-sm btn-outline-primary">Одеса</label>

                    <input class="btn-check" type="radio" name="location" id="location-11" value="ternopil" autocomplete="off" required>
                    <label for="location-11" class="btn btn-sm btn-outline-primary">Тернопіль</label>

                    <input class="btn-check" type="radio" name="location" id="location-12" value="kharkiv" autocomplete="off" required>
                    <label for="location-12" class="btn btn-sm btn-outline-primary">Харків</label>

                    <input class="btn-check" type="radio" name="location" id="location-13" value="khmelnytskyi" autocomplete="off" required>
                    <label for="location-13" class="btn btn-sm btn-outline-primary">Хмельницький</label>

                    <input class="btn-check" type="radio" name="location" id="location-14" value="cherkasy" autocomplete="off" required>
                    <label for="location-14" class="btn btn-sm btn-outline-primary">Черкаси</label>

                    <input class="btn-check" type="radio" name="location" id="location-15" value="chernihiv" autocomplete="off" required>
                    <label for="location-15" class="btn btn-sm btn-outline-primary">Чернігів</label>

                    <input class="btn-check" type="radio" name="location" id="location-17" value="uzhhorod" autocomplete="off" required>
                    <label for="location-16" class="btn btn-sm btn-outline-primary">Чернівці</label>

                    <input class="btn-check" type="radio" name="location" id="location-16" value="chernivtsi" autocomplete="off" required>
                    <label for="location-17" class="btn btn-sm btn-outline-primary">Ужгород</label>
                </div>

                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn btn-lg btn-primary">Start</button>
                    <button type="reset" class="btn btn-lg btn-light">Reset</button>
                </div>
            </form>
        </div>
        <div class="col-9">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">Level</th>
                        <th scope="col">Salary min</th>
                        <th scope="col">Salary max</th>
                        <th scope="col">Salary avg</th>
                    </tr>
                </thead>
                <tfoot data-filter-spinner>
                    <tr>
                        <td class="border-0 text-center" colspan="5">
                            <img src="{{ asset('spinner.gif') }}" alt="">
                        </td>
                    </tr>
                </tfoot>
                <tbody data-filter-results>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
