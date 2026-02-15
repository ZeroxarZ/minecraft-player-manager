<?php

return [
    'navigation_label' => 'Spelers',
    
    'columns' => [
        'avatar' => 'Avatar',
        'name' => 'Gebruikersnaam',
        'status' => 'Status',
        'world' => 'Wereld',
        'online' => 'Online',
        'offline' => 'Offline',
        'op' => 'Operator',
    ],

    'filters' => [
        'all' => 'Alle',
        'online' => 'Online',
        'offline' => 'Offline',
        'op' => 'OP',
        'banned' => 'Verbannen',
    ],

    'sections' => [
        'identity' => 'Identiteit',
        'statistics' => 'Statistieken',
        'statistics_desc' => 'Historische gegevens uit wereldstatistieken',
        'live_status' => 'Status',
        'live_status_desc' => 'Realtime gegevens van de server',
        'offline_status_desc' => 'Offline - Gegevens van laatste opgeslagen bestand',
        'rcon_disabled_status_desc' => 'RCON uitgeschakeld - Gegevens uit opslagbestand',
        'inventory' => 'Inventaris',
        'management' => 'Beheer',
        'management_desc' => 'Voer acties uit voor deze speler',
    ],

    'fields' => [
        'username' => 'Gebruikersnaam',
        'current_status' => 'Huidige status',
        'uuid' => 'UUID',
        'play_time' => 'Speeltijd',
        'distance_walked' => 'Afstand gelopen',
        'mobs_killed' => 'Mobs gedood',
        'deaths' => 'Sterfgevallen',
        'status' => 'Status',
        'xp_level' => 'XP Level',
        'gamemode' => 'Spelmodus',
        'visual_inventory' => 'Visuele inventaris',
    ],

    'stats' => [
        'health' => 'Gezondheid',
        'food' => 'Honger',
    ],

    'actions' => [
        'view' => 'Bekijken',
        'op' => [
            'label_op' => 'OP',
            'label_deop' => 'DEOP',
            'heading_op' => 'Operatorstatus toekennen',
            'heading_deop' => 'Operatorstatus intrekken',
            'desc_op' => 'Weet je zeker dat je deze speler Operator (OP) wilt maken?',
            'desc_deop' => 'Weet je zeker dat je de OP-rechten van deze speler wilt verwijderen?',
            'notify_op' => 'OP-commando verzonden',
            'notify_deop' => 'DEOP-commando verzonden',
        ],
        'clear_inventory' => [
            'label' => 'Inventaris legen',
            'desc' => 'Weet je zeker dat je de inventaris van deze speler wilt legen? Dit kan niet ongedaan worden gemaakt.',
            'notify' => 'Inventaris legen commando verzonden',
        ],
        'kick' => [
            'label' => 'Kick',
            'reason' => 'Reden',
            'default_reason' => 'Gekickt door operator',
            'notify' => 'Kick-commando verzonden',
        ],
        'ban' => [
            'label_ban' => 'Ban',
            'label_unban' => 'Unban',
            'reason' => 'Reden',
            'default_reason' => 'Verbannen door operator',
            'notify_ban' => 'Ban-commando verzonden',
            'notify_unban' => 'Unban-commando verzonden',
        ],
    ],

    'widget' => [
        'online_players' => 'Online spelers',
        'motd' => 'MOTD',
        'map' => 'Mapnaam',
        'units' => [
            'mins' => 'min',
        ],
    ],

    'pages' => [
        'list' => 'Spelerslijst',
        'view' => 'Speler bekijken',
    ],

    'values' => [
        'survival' => 'Survival',
        'creative' => 'Creative',
        'adventure' => 'Adventure',
        'spectator' => 'Spectator',
        'online' => 'Online',
        'offline' => 'Offline',
        'offline_data_source' => 'Offline (laatst opgeslagen gegevens)',
    ],

    'units' => [
        'mins' => 'min',
    ],

    'settings' => [
        'rcon_enabled' => 'RCON / Live Status inschakelen',
        'rcon_enabled_helper' => 'Schakelt realtime gegevens ophalen in (Inventaris, Gezondheid, etc.) via RCON. Vereist dat RCON is ingeschakeld in server.properties.',
        'nav_sort' => 'Navigatievolgorde',
        'nav_sort_helper' => 'Sorteervolgorde in het zijmenu. Lagere nummers staan hoger. (Standaard: 2)',
        'saved' => 'Instellingen succesvol opgeslagen.',
    ],
];
