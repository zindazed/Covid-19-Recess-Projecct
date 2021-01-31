#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#define MAX 80
#define PORT 8080
#define SA struct sockaddr
//client program that fetches commands from the user
int main(int argc, char **argv)
{
	int sockfd, connfd;
	struct sockaddr_in servaddr, cli;

	//note, argv1 is the command

	// socket create and varification
	sockfd = socket(AF_INET, SOCK_STREAM, 0);
	if (sockfd == -1) {
		printf("socket creation failed...\n");
		exit(0);
	}
	else
		printf("Socket successfully created..\n");
	bzero(&servaddr, sizeof(servaddr));

	// assign IP, PORT
	servaddr.sin_family = AF_INET;
	servaddr.sin_addr.s_addr = inet_addr("127.0.0.1");
	servaddr.sin_port = htons(PORT);

	// connect the client socket to server socket
	if (connect(sockfd, (SA*)&servaddr, sizeof(servaddr)) != 0) {
		printf("connection with the server failed...\n");
		exit(0);
	}
	else
		printf("connected to the server..\n");

	//sending the command to the server
        //cchecking if command is correct
        if(strncmp(argv[1], "Addpatient",10)==0){
	        //send arguments to server
	        puts("Addpatient entered");
	        //break;
	        }else if(strncmp(argv[1], "Addpatientlist",14)==0){
	        //send stdering to server program
	        puts("Addpatientlist entered");
	        //break;
	        }else if(strncmp(argv[1], "Check_status",12)==0){
	        //send string to server program
	        puts("Check_status entered");
	        //break;
	        puts("Check_status entered");
	        }else if(strncmp(argv[1], "Search",6)==0){
	        //send string to server program
	        puts("Search entered");
	        //break;
	        }else {
	        //puts("you have entered a wrong command\n to show commands available");
	        //puts("commands available\n1. Addpatient patientname, dtae, gender, category\n2. Addpatientlist\n3. Check_status\n4. Search <criteria>\n5. Addpatient filename.txt");
        }
        //sending the command
	//int *stringLen;
	//char *string = argv[argc];
	for(int i = 1; i<=argc; i++){
    	//printf("arg %d is %s, ",i, argv[i]);
    	strcat(str1, str2);
    	stringLen[i-1] = strlen(argv[i]);
    	send(sockfd, string, stringLen[i-1], 0);//sending data to the server program
	}



	// close the socket
	close(sockfd);
}
