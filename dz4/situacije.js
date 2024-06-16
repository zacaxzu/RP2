const situacija = [
    {
        tim1 : {
            ime: "Prva ekipa",
            boja: "blue", // boja točkice
            igraci: [
                { x: 200, y: 200 },
                { x: 250, y: 100 }
        ]},
        tim2 : {
            ime: "Druga ekipa",
            boja: "red", // boja točkice
            igraci: [
                { x: 270, y: 95 },
                { x: 240, y: 15 }
        ]},
        tip_situacije: "offside",
        lopta: [
            { x: 205, y: 195 }, // starting position of the ball
            { x: 245, y: 95 }  // ending position of the ball
        ],
        broj_glasova: [511,14]
    },
    {
        tim1 : {
            ime: "Prva ekipa",
            boja: "blue", // boja točkice
            igraci: [
                { x: 100, y: 100 }
        ]},
        tim2 : {
            ime: "Druga ekipa",
            boja: "red", // boja točkice
            igraci: [
                { x: 50, y: 200 },
                { x: 270, y: 15 }
        ]},
        tip_situacije: "gol",
        lopta: [
            { x: 105, y: 95 }, // starting position of the ball
            { x: 250, y: -6 }  // ending position of the ball
        ],
        broj_glasova: [222,166]
    }
    // Add more situations as needed
];

