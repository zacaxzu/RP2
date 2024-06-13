// Definiranje tima 1
const tim1 = {
    ime: "Prva ekipa",
    boja: "blue", // boja točkice
    igraci: [
        { x: 50, y: 50 },
        { x: 100, y: 150 },
        { x: 200, y: 250 },
        { x: 300, y: 100 },
        { x: 400, y: 200 }
    ],
    lopta: [
        { x: 120, y: 200 }, // starting position of the ball
        { x: 400, y: 25 }  // ending position of the ball
    ]
};

const situacija = [
    {
        tim1 : {
        ime: "Prva ekipa",
        boja: "blue", // boja točkice
        igraci: [
            { x: 50, y: 50 },
            { x: 100, y: 150 },
            { x: 200, y: 250 },
            { x: 300, y: 100 },
            { x: 400, y: 200 }
        ]},
        tip_situacije: "gol",
        lopta: [
            { x: 120, y: 200 }, // starting position of the ball
            { x: 400, y: 25 }  // ending position of the ball
        ],
        broj_glasova: [50, 30]
    },
    // Add more situations as needed
];

const tim2 = {
    ime: "Druga ekipa",
    boja: "red", // boja točkice
    igraci: [
        { x: 50, y: 50 },
        { x: 100, y: 150 },
        { x: 200, y: 250 },
        { x: 300, y: 100 },
        { x: 400, y: 200 }
    ]
};
