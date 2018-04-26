#贴子
create table bbs_article(
	id int not null primary key auto_increment  comment "主键id",
	user_id int default 0 comment "用户id,默认0是管理员",
	titile varchar(50) not null comment "标题",
	content text comment "内容",
	createtime datetime default null comment "创建时间",
	cate_id tinyint default 1 comment "分类id",
	uptime timestamp not null comment "修改时间",
	pic varchar(50) default null comment "封面图",
	pv int default 0 comment "浏览次数"
)engine=Myisam charset=utf8;
#用户
create table bbs_user(
	id int not null primary key auto_increment  comment "用户id",
	name varchar(12)  not null comment '用户',
	userpass varchar(32) default null comment "用户密码",
	auth varchar(20) default '新人' comment "新人或者会员",
	email varchar(50) not null default '' comment "邮箱",
	createtime datetime default null comment "创建时间",
	lasttime datetime default null comment "最后登录的时间",
	head_img varchar(50) default null comment "头像地址",
	createip int default null comment "将创建ip转换为int类型存储",
	lastip int  default null comment "上次登录ip",
	integral int default 0 comment "积分",
	del enum('0','1') default 0 comment "0代表没删除，1代表删除"
)engine=Myisam charset=utf8;
#用户资料
create table bbs_info(
	id int not null primary key auto_increment  comment "用户id",
	realname varchar(12) comment '用户真实姓名',
	sex enum('男','女','保密') default '保密' comment "性别",
	birthday int default null comment '出生年月',
	birthplace  varchar(20) default '' comment '出生地,用分号隔开',
	domicile varchar(20) default '' comment '居住地,用分号隔开',
	estate varchar(30) default '' comment '情感状态',
	bloodtype enum('A','B','AB','O','其他') default '其他' comment "血型",
	telephone  int default null comment '固定电话',
	phone varchar(14) default null comment '手机',
	qq int default null comment 'qq',
	msn int default null comment 'msn',
	al varchar(20) default '' comment '阿里',
	gschool varchar(20) default '' comment '毕业学校',
	education enum('博士','硕士','本科','专科','中学','小学','其他') default '其他' comment "学历",
	company varchar(20) default '' comment '公司',
	occupation varchar(20) default '' comment '职业',
	position varchar(20) default '' comment '职位',
	annualincome varchar(20) default '' comment '年收入',
	documenttype enum('身份证','护照','驾驶证') default '身份证' comment "证件类型",
	idnumber varchar(20) default '' comment '证件号',
	address varchar(40) default '' comment '邮件地址',
    zipcode varchar(15) default '' comment '邮编',
    phg varchar(15) default '' comment '个人主页',
    introduce varchar(100) default '' comment '自我介绍',
    Hobby varchar(100) default '' comment '兴趣爱好',
    signature text comment '个人签名'
)engine=Myisam charset=utf8;
insert into bbs_info values(null,'张美丽','女',19994,
	'黑龙江','黑龙江','已婚','A','6783403','18333511810','2344555','45555',
	'ali','东北石油','博士','微软','开发','经理','100w','身份证','123456789123456789',
	'252627@qq.com','100000','www.opps.com','我美丽又温柔善解人意又热情开朗','世界那么大我想去看看','山重水复疑无路，柳暗花明又一村');
#用户资料权限
#o代表公开 1代表仅好友可见 2代表私密
create table bbs_infoauth(
	user_id int not null primary key auto_increment  comment "用户id",
	realname int not null default 0 comment '用户真实姓名',
	sex int not null default 0  comment "性别",
	birthday int not null default 0 comment '出生年月',
	birthplace int not null default 0 comment '出生地,用分号隔开',
	domicile int not null default 0 comment '居住地,用分号隔开',
	estate int not null default 0 comment '情感状态',
	bloodtype int not null default 0 comment "性别",
	telephone int not null default 0 comment '固定电话',
	phone varchar(14) not null default 0 comment '手机',
	qq int not null default 0 comment 'qq',
	msn int not null default 0 comment 'msn',
	al int not null default 0 comment '阿里',
	gschool int not null default 0 comment '毕业学校',
	education int not null default 0 comment "学历",
	company int not null default 0 comment '公司',
	occupation int not null default 0 comment '职业',
	position int not null default 0 comment '职位',
	annualincome int not null default 0 comment '年收入',
	documenttype int not null default 0 comment "证件类型",
	idnumber int not null default 0 comment '证件号',
	address int not null default 0 comment '邮件地址',
    zipcode int not null default 0 comment '邮编',
    phg int not null default 0 comment '个人主页',
    introduce int not null default 0 comment '自我介绍',
    Hobby int not null default 0 comment '兴趣爱好',
    signature int not null default 0 comment '个人签名'
)engine=Myisam charset=utf8;
#论坛分类
create table bbs_forumtype(
	id int not null primary key auto_increment comment "分类id",
	name varchar(30) not null comment "分类名字",
	pic varchar(50) default null comment "封面图",
	pid int not null default 0 comment "0代表顶级"
)engine=Myisam charset=utf8;
#活动
create table bbs_activity(
	id int not null primary key auto_increment comment "活动id",
	user_id int not null default 0 comment "用户id",
	forumtype_id int not null default 0 comment "分类id",
	titile varchar(50) not null comment "标题",
	content text comment "内容",
	acttime varchar(20) default null comment "活动时间",
	city varchar(15) default null comment "城市",
	category varchar(20) default null comment "活动类别",
	num int default 0 not null comment '需要人数',
	info int default 0 comment "资料 0代表真实姓名,1代表手机,2代表qq",
	integral int default null comment "需要消耗的积分",
	spending int default 0 comment "每人花销",
	end varchar(20) default null comment "报名截止时间",
	activepic varchar(50) default '' comment "活动图片"
)engine=Myisam charset=utf8;
insert into bbs_activity values(15,12,11,'标题','活动内容','2018-8-8','沈阳','体育',333,0,150,666,'2018','image');
#评论
create table bbs_discuss(
	id int not null primary key auto_increment comment "评论者id",
	user_id int not null default 0 comment "用户id",
	discuss_id int not null default 0 comment "帖子id",
	content text comment "内容",
	reply_time timestamp not null comment "回复时间",
	state int default 0 comment "评论状态 0代表评论成功 1代表评论已被删除"
)engine=Myisam charset=utf8;
insert into bbs_discuss values(null,5,5,'哈哈哈',now(),0);.
#积分表
create table bbs_score(
	id int not null primary key auto_increment comment "积分id",
	user_id int not null default 0 comment "用户id",
	incident varchar(20) default null comment "事件",
	detail varchar(50) default null comment "详细",
	score int not null default 0 comment "积分",
	add_time datetime not null comment "积分增加时间"
)engine=Myisam charset=utf8;
insert into bbs_score values (null,5,'涨分啦','得分啦',5,now());
#轮播图
create table bbs_sheave(
	id int not null primary key auto_increment comment "轮播图id",
	sheave_pic varchar(50) default '' comment "轮播图片",
	description varchar(50) default null comment "轮播图描述",
	show_pic int default 0 comment "显不显示 0代表显示 1代表不显示"
)engine=Myisam charset =utf8;
insert into bbs_sheave values (null,'pic.jpg','图',0);
#后台管理员
create table bbs_admin(
	id int not null primary key auto_increment comment "管理员id",
	admin_name varchar(12) not null comment "管理员用户名",
	admin_pass varchar(32) not null comment "管理员密码",
	admin_phone varchar(14) not null default 0 comment '手机',
	admin_mail varchar(50) not null default '' comment "邮箱",
	admin_role int default 0 comment "管理员角色 0代表A级管理员 1代表B级管理员 2代表C级管理员",
	create_time datetime not null comment "创建时间",
	admin_state int default 0 comment "管理员状态 0代表登录 1代表下线",
	login_times int not null default 0 comment "登录次数",
	login_ip int  default null comment "登录ip"
)engine=Myisam charset=utf8;
insert into bbs_admin values(null,'啊啊啊','qidanei',13100000000,'243979@qq.com',1,now(),0,5,19216855);