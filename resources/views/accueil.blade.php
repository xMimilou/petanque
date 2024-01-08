<x-app-layout>


    <div class="container-fluid bg-white dark:bg-gray-800 shadow">
        <div class="row">
            <!-- h1 should have these classes:"font-bold text-xl text-center"  and be centered horizontaly and verticaly and box should have height 300px-->
            <div class="col-12 flex justify-center items-center h-screen" style="height: 300px;">
                <h1 class="text-4xl font-bold leading-tight text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
            </div>
        </div>
    </div>

    <section class="container-fluid bg-gray-200 mx-auto p-4">
        <div class="container p-4 mx-auto bg-gray-200">
            <a class="block bg-gray-800 text-white rounded-lg overflow-hidden shadow-lg" href="/match/1395185">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                        <!-- Sur les petits écrans, les éléments s'empilent verticalement -->
                        <!-- Sur les grands écrans, La Baule Escoublac à gauche, À venir au centre, Nationnal à droite -->
                        <span class="text-xl text-gray-500 md:w-1/3 md:text-left">La Baule Escoublac</span>
                        <span class="text-lg uppercase  md:w-1/3 md:text-center"><span
                                class="bg-red-600 rounded-lg p-2">À venir</span></span>
                        <span class="text-end font-medium md:w-1/3 md:text-right">Nationnal</span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <!-- Premier club -->
                        <div class="w-full md:w-60 flex items-center text-center mb-4 md:mb-0">
                            <p class="text-2xl font-medium">
                                <span>Pétanque Escoublacaise</span>
                            </p>
                        </div>
                        <!-- Informations sur le match -->
                        <div class="text-center mb-4 md:mb-0">
                            <p class="text-xl font-bold uppercase">
                                Sam. 13 Janv.<br>14H00
                            </p>
                        </div>
                        <!-- Deuxième club -->
                        <div class="w-full md:w-60 flex items-center">
                            <p class="text-2xl text-center font-medium">
                                <span>Pétanque Vannes</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>


    <div class="container-fluid mx-auto bg-grey-50 p-6 mb-5">
        <h2 class="text-2xl font-bold text-center mb-6">Partenaires</h2>
        <div class="text-center mb-6">
            <a href="/sponsors" class="text-blue-600 hover:text-blue-800 font-bold">Voir tous les Partenaires</a>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Boucle sur les sponsors -->
                @foreach ($sponsors->chunk(3) as $sponsorChunk)
                    <div class="swiper-slide">
                        <div class="flex flex-wrap">
                            @foreach ($sponsorChunk as $sponsor)
                                <div class="p-1 w-full md:w-1/3">
                                    <div class="p-4 rounded-lg flex flex-col items-center justify-center bg-white shadow-lg">
                                        <img src="{{ $sponsor->sponsor_logo }}" alt="{{ $sponsor->sponsor_name }}" class="max-h-40 w-auto mb-3">
                                        <h3 class="text-lg font-bold">{{ $sponsor->sponsor_name }}</h3>
                                        <a href="{{ $sponsor->sponsor_website }}" class="text-blue-600 hover:text-blue-800">Visiter le site</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    




    <section class="container-fluid bg-gray-200 mx-auto p-4">
        <h2 class="text-2xl font-bold text-center mb-6">Localisation du Club de Pétanque</h2>
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
                    <p class="text-lg mb-4">
                        Le club de pétanque est situé au Complexe sportif Alain Burban, un lieu facilement accessible
                        offrant d'excellentes installations pour les joueurs et les visiteurs. Venez nous rejoindre pour
                        découvrir le sport ou pour des compétitions amicales.
                    </p>
                    <p class="text-lg mb-4">
                        <strong>Adresse :</strong> <a
                            href="https://www.google.fr/maps/place/Complexe+sportif+Alain+Burban/@47.2952803,-2.3538707,18.75z/data=!4m6!3m5!1s0x48055d11995907bf:0x4244ada14b114e47!8m2!3d47.2955098!4d-2.3538581!16s%2Fg%2F11cs23nqzy?entry=ttu"
                            class="text-blue-600 hover:text-blue-800">Avenue du Bois Robin, 44500 La
                            Baule-Escoublac</a>
                    </p>
                    <p class="text-lg mb-4">
                        <strong>Téléphone :</strong> 02 40 60 90 30
                    </p>
                    <p class="text-lg mb-4">
                        <strong>Mail :</strong>
                        <a href="mailto:test@gmail.com" class="text-blue-600 hover:text-blue-800">Nous contacter</a>
                    </p>
                    <p class="text-lg mb-4">
                        <strong>Horaires :</strong>
                        <br>Lundi : 14h00 - 18h00
                        <br>Mardi : 14h00 - 18h00
                        <br>Mercredi : 14h00 - 18h00
                        <br>Jeudi : 14h00 - 18h00
                        <br>Vendredi : 14h00 - 18h00
                        <br>Samedi : 14h00 - 18h00
                        <br>Dimanche : 14h00 - 18h00
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="container-fluid bg-grey-50 mx-auto p-4">
        <div class="container mx-auto p-6">
            <h2 class="text-2xl font-bold text-center mb-6">Contactez-nous</h2>
            <form action="/send-message" method="POST" class="w-3/4 mx-auto">
                <!-- Condition: Si l'utilisateur n'est pas connecté, afficher ce champ -->
                @if (!Auth::check())
                    <!-- Champ e-mail visible seulement pour les utilisateurs non connectés -->
                    <div class="mb-4">
                        <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endif

                <div class="mb-4">
                    <label for="subject" class="block text-lg font-medium text-gray-700">Objet</label>
                    <input type="text" id="subject" name="subject"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-lg font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="4"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Envoyer le
                        message</button>
                </div>
            </form>
        </div>
        </div>


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


</x-app-layout>