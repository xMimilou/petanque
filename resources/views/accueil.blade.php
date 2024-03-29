<x-app-layout>


    <div class="background-carousel container-fluid bg-white shadow">
        <div class="row">
            <div class="col-12 flex justify-center items-center h-screen " style="height: 300px;">
                <h1 class="text-4xl font-bold leading-tight text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
            </div>
        </div>
    </div>


    <section class="container-fluid bg-gray-200 mx-auto p-4">
        <div class="container p-4 mx-auto bg-gray-200">
            <!-- if no tournois find in the database -->
            @if ($tournois->isEmpty())
                <h2 class="text-2xl font-bold text-center mb-6">Aucun tournoi à venir</h2>
            @else
                <a class="block bg-blue-600 text-white rounded-lg overflow-hidden shadow-lg"
                    href="/tournois/{{ $tournois[0]->id }}">
                    <div class="p-4">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                            <!-- Sur les petits écrans, les éléments s'empilent verticalement -->
                            <!-- Sur les grands écrans, La Baule Escoublac à gauche, À venir au centre, Nationnal à droite -->
                            <span
                                class="text-xl text-white-500 md:w-1/3 md:text-left">{{ $tournois[0]->tournoi_name }}</span>
                            <span class="text-lg uppercase  md:w-1/3 md:text-center"><span
                                    class="bg-red-600 rounded-lg p-2">À venir</span></span>
                            <span
                                class="text-end font-medium md:w-1/3 md:text-right">{{ $tournois[0]->tournoi_location }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <!-- Premier club -->
                            <div class="w-full md:w-60 flex items-center text-center mb-4 md:mb-0">
                                <p class="text-2xl font-medium">
                                    <span>{{ $tournois[0]->tournoi_team_local }}</span>
                                </p>
                            </div>
                            <!-- Informations sur le match -->
                            <div class="text-center mb-4 md:mb-0">
                                <p class="text-xl font-bold uppercase">
                                    <!--Sam. 13 Janv.<br>14H00 en français-->
                                    <!-- display date in french -->
                                    @php
                                        \Carbon\Carbon::setLocale('fr');
                                        $date = \Carbon\Carbon::parse($tournois[0]->tournoi_start_date);
                                        $jour = $date->translatedFormat('l j'); // Samedi 13
                                        $mois = substr($date->translatedFormat('F'), 0, 4); // Janv, avec ajustement manuel si nécessaire
                                        // get hour and minute
                                        $heure = $date->format('H:i');

                                        // Affichage formaté
                                        echo "{$jour} {$mois}.<br>{$heure}";
                                    @endphp

                                </p>
                            </div>
                            <!-- Deuxième club -->
                            <div class="w-full md:w-60 flex items-end justify-end">
                                <p class="text-2xl font-medium text-right">
                                    <span>{{ $tournois[0]->tournoi_team_visitor }}</span>
                                </p>
                            </div>

                        </div>
                    </div>
                </a>
            @endif
        </div>
    </section>


    <div class="container-fluid mx-auto bg-grey-50 p-4 mb-5">
        <h2 class="text-2xl font-bold text-center mb-3">Partenaires</h2>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Boucle sur les sponsors -->
                @foreach ($sponsors->chunk(3) as $sponsorChunk)
                    <div class="swiper-slide">
                        <div class="flex flex-wrap">
                            @foreach ($sponsorChunk as $sponsor)
                                <div class="p-1 w-full md:w-1/3">
                                    <div
                                        class="p-4 rounded-lg flex flex-col items-center justify-center bg-white shadow-lg">
                                        <!-- exemple $sponsor->sponsor_logo = "/storage/sponsors_logos/V3veShAU13ezmQqO2ANkyRqTuJdABOK1BQPQ069J.png" mais en public "qn9DspX1GtUGzWM8mPo0FSzupOJIKXtq5Q8BZeSX.jpg" or le dossier sponsors_logos est toujours nécessaire  -->
                                        <img src="{{ asset( 'storage/' . $sponsor->sponsor_logo) }}"
                                            alt="{{ $sponsor->sponsor_name }}" class="w-32 h-32 object-contain">


                                        <h3 class="text-lg font-bold">{{ $sponsor->sponsor_name }}</h3>
                                        <!-- lien vers les détails du sponsor -->
                                        <a href="/sponsors/{{ $sponsor->id }}"
                                            class="text-blue-600 hover:text-blue-800 font-bold">Voir le
                                            Partenaire</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-center mt-6">
            <a href="/sponsors" class="text-blue-600 hover:text-blue-800 font-bold">Voir tous les Partenaires</a>
        </div>
    </div>






    <section class="container-fluid bg-gray-200 mx-auto p-4">
        <h2 class="text-2xl font-bold text-center mb-6">Club de Pétanque de la Baule-Escoublac</h2>
        <div class="flex flex-wrap -mx-2">
            <!-- Div pour la carte -->
            <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                <iframe width="100%" height="400" frameborder="0" style="border:0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=-2.3803000%2C47.2997000%2C-2.331100%2C47.278000&layer=mapnik&marker=47.29549%2C-2.35371"
                    allowfullscreen>
                </iframe>
            </div>
            <!-- Div pour le texte -->
            <div class="w-full md:w-1/2 px-2">
                <div class="w-full px-2">
                    {!! $textContent->content !!}
                </div>
                {{-- fixed image --}}
                <img src="{{ asset('images/bureau.jpg') }}"
                    class="w-full h-64 object-cover rounded-lg shadow-lg mt-4" alt="bureau">

            </div>
        </div>
    </section>

    <section class="container-fluid bg-grey-50 mx-auto p-4">
        <div class="container mx-auto p-6">
            <h2 class="text-2xl font-bold text-center mb-6">Contactez-nous</h2>
            <form action="{{ route('user.contacts.store') }}" method="POST" class="w-3/4 mx-auto">
                @csrf <!-- Ajout du token CSRF -->
                <!-- Condition: Si l'utilisateur n'est pas connecté, afficher ce champ -->
                @if (Auth::check())
                    <!-- Champ e-mail visible seulement pour les utilisateurs non connectés -->
                    <div class="mb-4">
                        <label for="contact_sender_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="contact_sender_email" id="contact_sender_email"
                            value="{{ Auth::user()->email }}" readonly
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                @else
                    <div class="mb-4">
                        <label for="contact_sender_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="contact_sender_email" id="contact_sender_email" required
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                @endif

                <div class="mb-4">
                    <label for="contact_sender_object" class="block text-sm font-medium text-gray-700">Objet</label>
                    <input type="text" name="contact_sender_object" id="contact_sender_object" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="mb-6">
                    <label for="contact_sender_message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="contact_sender_message" id="contact_sender_message" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Envoyer
                        le
                        message</button>

                </div>
            </form>
        </div>
        </div>

        <style>
            .background-carousel {
                background-size: cover;
                background-position: center;
                transition: background-image 0.5s ease-in-out;
                /* Transition douce entre les images */
            }
        </style>

        <script>
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const images = [
                    @foreach ($carouselImages as $image)
                        "{{ asset($image->image_path) }}",
                    @endforeach
                ];
                let currentIndex = 0;
                const carouselDiv = document.querySelector('.background-carousel');
                carouselDiv.style.backgroundImage = `url('${images[images.length - 1]}')`;
                if (carouselDiv) {
                    setInterval(() => {
                        carouselDiv.style.backgroundImage = `url('${images[currentIndex]}')`;
                        currentIndex = (currentIndex + 1) % images.length;
                    }, 5000); // Change l'image toutes les 5 secondes
                } else {
                    console.error("Element '.background-carousel' not found");
                }

            });
        </script>



</x-app-layout>
