<x-guest-layout>
    <div class="pt-4 bg-gray-100 pb-12">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-jet-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                <h2 class="text-4xl my-10 text-center">Déclaration d'accessibilité</h2>

                <p class="my-3">NoteUniv s’engage à rendre ses sites internet, intranet, extranet et ses progiciels
                    accessibles (et ses
                    applications mobiles et mobilier urbain numérique) conformément à l’article 47 de la loi n°2005-102
                    du 11 février 2005.</p>

                @if (Auth::user()->is_admin)
                    <p class="my-3">Cette déclaration d’accessibilité s’applique à <a href="{{ route('dashboard-admin') }}">https://noteuniv.lienhardt.etu.mmi-unistra.fr/</a>.</p>
                @else
                    <p class="my-3">Cette déclaration d’accessibilité s’applique à <a href="{{ route('dashboard') }}">https://noteuniv.lienhardt.etu.mmi-unistra.fr/</a>.</p>
                @endif
                <h3 class="text-3xl mt-10">État de conformité</h3>

                <p class="my-3">NoteUniv est totalement en grande partie conforme avec le référentiel général
                    d’amélioration de
                    l’accessibilité (RGAA), version 4 en raison des non-conformités et des dérogations énumérées
                    ci-dessous.</p>

                <h4 class="text-xl mt-5 font-bold">Résultats des tests</h4>

                <p class="my-3">L’audit de conformité réalisé par NoteUniv Corporate révèle que :</p>
                <ul class="pl-5">
                    <li class="list-disc">80% des critères du RGAA version 4 sont respectés</li>
                </ul>

                <h3 class="text-3xl mt-10">Contenus non accessibles</h3>
                <h4 class="text-xl mt-5 font-bold">Non-conformités</h4>
                <p>Le menu utilisateur lorqu'on est étudiant n'est pas navigable avec le clavier. Pour toute question sur cette démarche, vous pouvez nous contacter via le formulaire de contact. La version 2023 respectera les critères du RGAA sur les contenus additionnels
                    apparaissant via les styles
                    CSS.</p>

                <h3 class="text-3xl mt-10">Établissement de cette déclaration d’accessibilité</h3>

                <p class="my-3">Cette déclaration a été établie le 17/03/2022.</p>

                <h4 class="text-xl mt-5 font-bold">Technologies utilisées pour la réalisation de NoteUniv</h4>
                <ul class="pl-5">
                    <li class="list-disc">Laravel (Jetstream)</li>
                    <li class="list-disc">tailwindcss</li>
                    <li class="list-disc">Alpine.js</li>
                </ul>

                <h4 class="text-xl mt-5 font-bold">Environnement de test</h4>
                <p class="my-3">Les vérifications de restitution de contenus ont été réalisées sur la base de la
                    combinaison fournie par la base de
                    référence du RGAA, avec les versions suivantes :</p>
                <ul class="pl-5">
                    <li class="list-disc">Firefox et NVDA</li>
                    <li class="list-disc">Safari et VoiceOver</li>
                </ul>


                <h4 class="text-xl mt-5 font-bold">Outils pour évaluer l’accessibilité</h4>
                <ul class="pl-5">
                    <li class="list-disc">Wave</li>
                </ul>

                <h4 class="text-xl mt-5 font-bold">Pages du site ayant fait l’objet de la vérification de conformité
                </h4>
                <ol class="pl-5">
                    <li class="list-decimal"><a href="{{ route('login') }}">Connexion (si non connecté)</a></li>
                    <li class="list-decimal"><a href="{{ route('dashboard-admin') }}">Panel administrateur (si administrateur)</a></li>
                    <li class="list-decimal"><a href="{{ route('dashboard') }}">Tableau de bord (si étudiant)</a></li>
                    <li class="list-decimal"><a href="{{ route('grades') }}">Notes & moyennes (si étudiant)</a></li>
                    <li class="list-decimal"><a href="{{ route('ranking') }}">Classement (si étudiant)</a></li>
                    <li class="list-decimal"><a href="{{ route('profile.show') }}">Paramètres utilisateur</a></li>
                    <li class="list-decimal"><a href="{{ route('contact') }}">Nous contacter</a></li>
                </ol>

                <h3 class="text-3xl mt-10">Retour d’information et contact</h3>

                <p class="my-3">Si vous n’arrivez pas à accéder à un contenu ou à un service, vous pouvez contacter le
                    responsable de
                    NoteUniv
                    pour être orienté vers une alternative accessible ou obtenir le contenu sous une autre forme.</p>

                <ul class="pl-5">
                    <li class="list-disc"><a href="{{ route('contact') }}">Envoyer un message</a></li>
                </ul>

                <h3 class="text-3xl mt-10">Voies de recours</h3>

                <p class="my-3">Si vous constatez un défaut d’accessibilité vous empêchant d’accéder à un contenu ou une
                    fonctionnalité
                    du site, que
                    vous nous le signalez et que vous ne parvenez pas à obtenir une réponse de notre part, vous êtes en
                    droit de faire
                    parvenir vos doléances ou une demande de saisine au Défenseur des droits.</p>

                <p class="my-3">Plusieurs moyens sont à votre disposition :</p>

                <ul class="pl-5">
                    <li class="list-disc"><a href="https://formulaire.defenseurdesdroits.fr">Écrire un message au
                            Défenseur des droits</a></li>
                    <li class="list-disc"><a href="https://www.defenseurdesdroits.fr/saisir/delegues">Contacter le
                            délégué du Défenseur des droits dans votre région</a></li>
                    <li class="list-disc">Envoyer un courrier par la poste (gratuit, ne pas mettre de timbre)
                        <br>
                        Défenseur des droits
                        <br>
                        Libre réponse 71120
                        <br>
                        75342 Paris CEDEX 07
                    </li>
                </ul>
            </div>

            @if (Auth::user()->is_admin)
                <div class="flex flex-col items-center m-5">
                    <a href="{{ route('dashboard-admin') }}" class="btn-link mt-3">
                        <span>{{ __('Back to Admin dashboard') }}</span>
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center m-5">
                    <a href="{{ route('dashboard') }}" class="btn-link mt-3">
                        <span>{{ __('Back to dashboard') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
