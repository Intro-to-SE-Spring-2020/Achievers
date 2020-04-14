import mysql.connector
import random
userId = 'root'
passId = ''
hostId = '127.0.0.1'

'''
choice = str(input("Are you hosting locally (y/n): "))

if choice == 'n':
    userId = str(input("\nEnter the username: "))
    passId = str(input("\nEnter the password: "))
    hostId = str(input("\nEnter the host: "))
'''


cnx = mysql.connector.connect(user= userId, password= passId,
                              host=hostId)

cursor = cnx.cursor()

cursor.execute("drop database if exists achievers;")
print("Dropped old database")

cursor.execute("create database if not exists achievers;")
print("Created database")

cursor.execute("use achievers;")
print("using database")

cursor.execute("create table if not exists `users` (`uid` int not null auto_increment primary key, `userName` varchar(255) not null, `email` varchar(255) not null, `password` varchar(8) not null) engine = InnoDB;")
print("created users")

cursor.execute("create table if not exists `tweets` (`tid` int not null auto_increment primary key, `uid` int not null, `body` varchar(140) not null, `date` varchar(23) not null, `time` time(6) not null, foreign key(uid) references users(uid)) engine = InnoDB;")
print("created tweets")

cursor.execute("create table if not exists `following` (`user_id` int not null, `follower_id` int not null, primary key(user_id, follower_id), foreign key(user_id) references users(uid) on delete cascade, foreign key(follower_id) references users(uid) on delete cascade) engine = InnoDB;")
print("created following")

cursor.execute("create table if not exists `liked` (`user_id` int not null, `tweet_id` int not null, primary key(user_id, tweet_id), foreign key(user_id) references users(uid), foreign key(tweet_id) references tweets(tid)) engine = InnoDB;")
print("created liked")

print("Achievers database ready!")

cnx.close()
