Mark[] mark;
final int mark_num = 30;
final color colors[] = {color(0xff, 0x7f, 0x7f), color(0xff, 0x7f, 0xbf), color(0xff, 0x7f, 0xff), color(0xbf, 0x7f, 0xff), color(0x7f, 0x7f, 0xff), color(0x7f, 0xbf, 0xff), color(0x7f, 0xff, 0xff), color(0x7f, 0xff, 0xbf), color(0x7f, 0xff, 0x7f), color(0xbf, 0xff, 0x7f), color(0xff, 0xff, 0x7f), color(0xff, 0xbf, 0x7f)};

void setup(){
	size(innerWidth,innerHeight);
	smooth();
	noStroke();
	colorMode(RGB,256);

	mark = new Mark[mark_num];

	for(int i=0;i<mark_num;i++){
		int y = int(random(0,innerHeight));
		int x = int(random(0,innerWidth));
		int size = int(random(20,50));
		color c = colors[ int(random(0, colors.length ))  ];
		int speed = int(random(1,3));
		mark[i] = new Mark(y, x, size, c, speed);
	}

}

void draw(){
	size(innerWidth,innerHeight);
	background(255,255,255);
	for(int i=0;i<mark_num;i++){
		mark[i].update();
	}	
}

class Mark{
	float x,y;
	int size;
	color c;
	int speed;

	Mark(float y,float x,int size,color c,int speed){
		this.y = y;
		this.x = x;
		this.size = size;
		this.c = c;
		this.speed = speed;
	}

	void update(){
		float xtmp,ytmp;
		y+=speed;
		if(y-size<= mouseY && mouseY<=y && x<= mouseX && mouseX<=x+size){
			c = colors[ int(random(0, colors.length ))  ];
		}

		if(y-size > height ){
			x = random(0,innerWidth);
			y = 0;
		}
		
		fill(c);
		textSize(size);
		text("〒", x,y);
	}

}

