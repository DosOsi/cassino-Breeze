var canvas = null;
var ctx = null;
var mouse_pos = {x:0,y:0};

document.addEventListener("DOMContentLoaded",() => {
    canvas = document.getElementById("main-canvas");
    ctx = canvas.getContext("2d");
    init();

    canvas.addEventListener("mousemove", (e) => {
        mouse_pos = get_mouse_pos(e);
        collide_obj = collide_mouse(mouse_pos);
        if (collide_obj != null) {
            if (collide_obj.id == "rollButton" && !rolling) {
                canvas.style.cursor = "pointer";
            }
        } else {
            canvas.style.cursor = "default";
        };
    });

    canvas.addEventListener("mousedown", (e) => {
        mouse_pos = get_mouse_pos(e);
        collide_obj = collide_mouse(mouse_pos);
        if (collide_obj != null) {
            if (collide_obj.id == "rollButton") {
                roll();
                canvas.style.cursor = "default";
            }
        }
    });
    
    slot_images.push(document.getElementById("img-slot-tigre"));
    slot_images.push(document.getElementById("img-slot-bell"));
    slot_images.push(document.getElementById("img-slot-beer"));
    slot_images.push(document.getElementById("img-slot-cat"));
    slot_images.push(document.getElementById("img-slot-honey"));
    slot_images.push(document.getElementById("img-slot-sheep"));
    slot_images.push(document.getElementById("img-slot-snowman"));

});

class Sprite {
    constructor(image,position,size,centered=false,color = "white") {
        this.image = image;
        this.position = position;
        this.size = size;
        this.velocity = {x: 0, y: 0};
        this.centered = centered;
        this.color = color;
    }
    draw() {
        if (this.image == null) {
            ctx.fillStyle = this.color;
            ctx.fillRect(
                (this.centered) ? this.position.x - this.size.x/2 : this.position.x,
                (this.centered) ? this.position.y - this.size.y/2 : this.position.y,
                this.size.x,
                this.size.y
            );
            return;
        }
        ctx.drawImage(
            this.image,
            (this.centered) ? this.position.x - this.size.x/2 : this.position.x,
            (this.centered) ? this.position.y - this.size.y/2 : this.position.y,
            this.size.x,
            this.size.y
        );
    }
    update() {
        this.position.x += this.velocity.x;
        this.position.y += this.velocity.y;
    }
}

class SpriteButton extends Sprite {
    constructor (id,image,position,size,centered=false,color = "white") {
        super(image,position,size,centered);
        this.id = id;
    };
}

class SpriteText extends Sprite {
    constructor (text,font,position,size,color = "white") {
        super(null,position,size,true,color);
        this.text = text;
        this.font = font;
    };
    draw() {
        ctx.font = this.font;
        ctx.fillStyle = this.color;
        ctx.fillText(this.text,
            this.position.x,
            this.position.y,
            this.size,
        );
    }
}

const FPS = 75;
const draw_queue = [];
const update_queue = [];
const mouse_response = [];
const tween_queue = [];

const slots_containers = [];
const slots = [
    [],[],[]
];

const slot_count = 16;
const slot_images = [];

function init() {
    var slotContainerLeft = new Sprite(
        null,
        {x: canvas.width/2 - canvas.width/100 * 28 - 5, y: canvas.height/2 - canvas.height/10},
        {x: canvas.width/100 * 28, y: canvas.height/2},
        true,
        "white"
    );
    var slotContainerCenter = new Sprite(
        null,
        {x: canvas.width/2, y: canvas.height/2 - canvas.height/10},
        {x: canvas.width/100 * 28, y: canvas.height/2},
        true,
        "white"
    );
    var slotContainerRight = new Sprite(
        null,
        {x: canvas.width/2 + canvas.width/100 * 28 + 5, y: canvas.height/2 - canvas.height/10},
        {x: canvas.width/100 * 28, y: canvas.height/2},
        true,
        "white"
    );
    
    draw_queue.push(slotContainerLeft);
    draw_queue.push(slotContainerCenter);
    draw_queue.push(slotContainerRight);

    slots_containers.push(slotContainerLeft);
    slots_containers.push(slotContainerCenter);
    slots_containers.push(slotContainerRight);
    
    count = 0;
    for (container of slots_containers) {
        for (i = 0; i < slot_count+1; i++) {
            var slot = new Sprite(
                document.getElementById("img-slot-tigre"),
                {x:container.position.x,y:container.position.y - container.size.y/2 + 112 + slot_count * 96 - i * 96},
                {x:96,y:96},
                true
            );
            draw_queue.push(slot);
            update_queue.push(slot);
            slots[count].push(slot);
        };
        count += 1;
    };

    var blackCover1 = new Sprite(
        null,
        {x: canvas.width/2, y: canvas.height/2 - canvas.height/10 + canvas.height/2},
        {x: canvas.width, y: canvas.height/2},
        true,
        "black"
    );
    var blackCover2 = new Sprite(
        null,
        {x: canvas.width/2, y: canvas.height/2 - canvas.height/10 - canvas.height/2},
        {x: canvas.width, y: canvas.height/2},
        true,
        "black"
    );
    draw_queue.push(blackCover1);
    draw_queue.push(blackCover2);

    var backgroundCassinoMachine = new Sprite(
        document.getElementById("img-cassino-machine"),
        {x:canvas.width/2,y:canvas.width/2},
        {x:1028,y:1028},
        true
    );

    draw_queue.push(backgroundCassinoMachine);
    
    rollButton = new SpriteButton(
        "rollButton",
        document.getElementById("img-roll-button"),
        {x: canvas.width/2, y: canvas.height - 128/2 - 16},
        {x: 128, y: 128},
        true
    );
    draw_queue.push(rollButton);
    mouse_response.push(rollButton);

    priceText = new SpriteText(
        "1.00R$",
        "16px Arial",
        {x: canvas.width/2 - 4 * 6, y: canvas.height - 128/2 + 10},
        128,
        "black"
    )
    draw_queue.push(priceText);

    backgroundWinContainer = new Sprite(
        null,
        {x:canvas.width/2 + 8,y:canvas.width + 128/1.3},
        {x:195,y:32},
        true,
        "orange",
    );

    draw_queue.push(backgroundWinContainer);

    winText = new SpriteText(
        "---",
        "32px Arial",
        {x: canvas.width/2 - 32/4 * 3 + 16, y: canvas.height - 190},
        128*2,
        "black"
    )
    draw_queue.push(winText);

    rolling_max_y = slots_containers[0].position.y - slots_containers[0].size.y/2 + 112;

    const update_frame_tick = setInterval(update_frame, 1000/FPS);
    const draw_frame_tick = setInterval(draw_frame, 1000/FPS);
};

var rolling = false;
var rolling_max_y = 0;
var validateMatrixSaved = null;
var moneyGainedSaved = null;
function roll() {
    if (rolling) return;
    let velocity_accumulator = 20;
    let result = Server.get_result();
    let resultMatrix = result[0];
    validateMatrixSaved = result[1];
    moneyGainedSaved = result[2];
    winText.text = "---";
    winText.position.x = canvas.width/2 - 32/4 * winText.text.length + 16;
    
    for (obj in explosions) {
        draw_queue.pop();
    }

    for (container_idx in validateMatrixSaved) {
        for (slot_idx in validateMatrixSaved[container_idx]) {
            slots[container_idx][slots[container_idx].length - slot_idx - 1].size = {x: 96, y: 96};
        };
    };

    for (container_idx in slots) {
        for (slot_idx in slots[container_idx]) {
            slots[container_idx][slot_idx].position.y -= 96 * (slot_count - 2);
            slots[container_idx][slot_idx].velocity.y += velocity_accumulator;
            
            if (slots[container_idx].length - slot_idx < 4) {
                slots[container_idx][slot_idx].image = slot_images[Number(resultMatrix[container_idx][slots[container_idx].length - slot_idx - 1])];
            } else {
                if (slot_idx < 3) {
                    slots[container_idx][slot_idx].image = slots[container_idx][slots[container_idx].length - 3 + Number(slot_idx)].image;
                } else {
                    slots[container_idx][slot_idx].image = slot_images[Math.floor(Math.random() * slot_images.length)];
                };
            };
        };
        velocity_accumulator += 5;
    };
    rolling = true;
};

var explosions = [];
function win() {
    explosions = [];
    winText.text = "+ " + moneyGainedSaved.toFixed(2) + "R$";
    winText.position.x = canvas.width/2 - 32/4 * winText.text.length;

    for (container_idx in validateMatrixSaved) {
        for (slot_idx in validateMatrixSaved[container_idx]) {
            if (validateMatrixSaved[container_idx][slot_idx] >= 1) {
                slots[container_idx][slots[container_idx].length - slot_idx - 1].size = {x: 112, y: 112};
                let explosionInstance = new Sprite(
                    document.getElementById("img-explosion-effect"),
                    slots[container_idx][slots[container_idx].length - slot_idx - 1].position,
                    slots[container_idx][slots[container_idx].length - slot_idx - 1].size,
                    true
                );
                tween_queue.push({
                    obj:explosionInstance,
                    property: "size",
                    duration: Math.ceil(explosionInstance.size.x/3),
                    modifier: -3,
                    max_clamp: 128,
                    min_clamp: 0
                });
                explosions.push(explosionInstance);
                draw_queue.push(explosionInstance);
            } else {
                slots[container_idx][slots[container_idx].length - slot_idx - 1].size = {x: 82, y: 82};
            };
        };
    };
};

function draw_frame() {
    for (obj of draw_queue) {
        obj.draw();
    };
    if (rolling) {
        ctx.save();

        ctx.beginPath();
        ctx.arc(
            rollButton.position.x,
            rollButton.position.y,
            64 - 8, 0, 2 * Math.PI
            );
        ctx.closePath();

        ctx.clip();
        ctx.fillStyle = "rgba(0, 0, 0, 0.5)";
        ctx.fillRect(
            rollButton.position.x - 128/2,
            rollButton.position.y - 128/2,
            128, 128
            );
        
        ctx.restore();

    }
};
function update_frame() {
    for (obj of update_queue) {
        obj.update();
    };
    for (tween_idx in tween_queue) {
        if (tween_queue[tween_idx].duration <= 0) {
            tween_queue.splice(tween_idx,1);
        } else {
            if (tween_queue[tween_idx].property == "size") {
                tween_queue[tween_idx].obj.size = 
                {
                    x:Math.min(Math.max(tween_queue[tween_idx].obj.size.x + tween_queue[tween_idx].modifier, tween_queue[tween_idx].min_clamp), tween_queue[tween_idx].max_clamp),
                    y:Math.min(Math.max(tween_queue[tween_idx].obj.size.y + tween_queue[tween_idx].modifier, tween_queue[tween_idx].min_clamp), tween_queue[tween_idx].max_clamp)
                };
            } else {
                tween_queue[tween_idx].obj[tween_queue[tween_idx]] = tween_queue[tween_idx].obj[tween_queue[tween_idx]] + tween_queue[tween_idx].modifier;
            };
            tween_queue[tween_idx].duration -= 1;
        };
    };
    if (rolling) {
        if (slots[2][slots[2].length-1].position.y >= rolling_max_y) {
            for (slot of slots[2]) {
                slot.velocity.y = 0;
                slot.position.y -= slots[2][slots[2].length-1].position.y - rolling_max_y;
            }
        } else if (slots[2][slots[2].length-1].position.y >= rolling_max_y-100) {
            for (slot of slots[2]) {
                slot.velocity.y = Math.max(slot.velocity.y * 0.7, 1);
            };
        } else {
            return;
        };

        if (slots[1][slots[1].length-1].position.y >= rolling_max_y) {
            for (slot of slots[1]) {
                slot.velocity.y = 0;
                slot.position.y -= slots[1][slots[1].length-1].position.y - rolling_max_y;
            }
        } else if (slots[1][slots[1].length-1].position.y >= rolling_max_y-100) {
            for (slot of slots[1]) {
                slot.velocity.y = Math.max(slot.velocity.y * 0.7, 1);
            };
        } else {
            return;
        };

        if (slots[0][slots[0].length-1].position.y >= rolling_max_y) {
            for (slot of slots[0]) {
                slot.velocity.y = 0;
                slot.position.y -= slots[0][slots[0].length-1].position.y - rolling_max_y;
            }
            rolling = false;

            collide_obj = collide_mouse(mouse_pos);
            if (collide_obj != null) {
                if (collide_obj.id == "rollButton" && !rolling) {
                    canvas.style.cursor = "pointer";
                }
            } else {
                canvas.style.cursor = "default";
            };

            win();

        } else if (slots[0][slots[0].length-1].position.y >= rolling_max_y-100) {
            for (slot of slots[0]) {
                slot.velocity.y = Math.max(slot.velocity.y * 0.7, 1);
            };
        } else {
            return;
        };
    };
};

// helper functions
function get_mouse_pos(e) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: (e.clientX - rect.left) / rect.width * canvas.width,
        y: (e.clientY - rect.top) / rect.height * canvas.height,
    };
};
function collide_mouse(pos) {
    for (obj of mouse_response) {
        x_modifier = (obj.centered) ? obj.size.x/2 : 0;
        y_modifier = (obj.centered) ? obj.size.y/2 : 0;
        if (
            obj.position.x - x_modifier < pos.x &&
            obj.position.x - x_modifier + obj.size.x > pos.x &&
            obj.position.y - y_modifier < pos.y &&
            obj.position.y - y_modifier + obj.size.y > pos.y) {
                return obj;
        }
    }
}

// would be server side.

Server = {};
Server.user = 25.00

Server.slot_chances = [
    1, //tigre
    7, //bell
    8, //beer
    10, //cat
    20, //honey
    50, //sheep
    2, //snowman
];
Server.slot_values = [ //3x combo
    30.0, //tigre
    7.5, //bell
    4.5, //beer
    3.0, //cat
    1.0, //honey
    0.55, //sheep
    1.0, //snowman
];

Server.get_result = () => {
    let resultMatrix = [
        [],[],[]
    ];
    for (x = 0; x < 3; x++) {
        for (y = 0; y < 3; y++) {
            let rollValue = Math.floor(Math.random() * Server.slot_chances.reduce((sum,a) => sum + a, 0));
            let currentValue = 0;
            for (i in Server.slot_chances) {
                currentValue += Server.slot_chances[i];
                if (rollValue <= currentValue) {
                    resultMatrix[x].push(i);
                    break;
                };
            };
            
        };
    };
    return [resultMatrix,Server.validate_result(resultMatrix),Server.get_money_result(resultMatrix,Server.validate_result(resultMatrix))];
};
Server.validate_result = (resultMatrix) => {
    let validateMatrix = [
        [0,0,0],[0,0,0],[0,0,0]
    ];
    let possibleCombinations = [
        [
            [0,0],
            [1,0],
            [2,0]
        ],
        [
            [0,1],
            [1,1],
            [2,1]
        ],
        [
            [0,2],
            [1,2],
            [2,2]
        ],
        [
            [0,0],
            [0,1],
            [0,2]
        ],
        [
            [1,0],
            [1,1],
            [1,2]
        ],
        [
            [2,0],
            [2,1],
            [2,2]
        ],
    ];

    for (combination of possibleCombinations) {
        let slot_value = null;
        let is_unique = true;
        for (pos in combination) {
            if (slot_value == null) {
                slot_value = resultMatrix[combination[pos][0]][combination[pos][1]];
            } else {
                if (slot_value != resultMatrix[combination[pos][0]][combination[pos][1]]) {
                    is_unique = false;
                    break;
                };
            };
        };
        if (is_unique) {
            for (pos in combination) {
                validateMatrix[combination[pos][0]][combination[pos][1]] += 1;
            }
        }
    };

    return validateMatrix;
};

Server.get_money_result = (resultMatrix, validateMatrix) => {
    let mult = 0;
    let total_money = 0.0;
    for (container_idx in validateMatrix) {
        mult += validateMatrix[container_idx].reduce((acc,a) => acc + a,0);
        for (slot_idx in validateMatrix[container_idx]) {
            if (validateMatrix[container_idx][slot_idx] >= 1) {
                total_money += (Server.slot_values[resultMatrix[container_idx][slot_idx]] * validateMatrix[container_idx][slot_idx])/3
            };
        };
    };
    return Math.round(total_money * mult * 100)/100;
};