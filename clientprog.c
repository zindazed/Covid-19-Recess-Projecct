#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <unistd.h>
#include <netdb.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#define MAX 1500
#define PORT 8080
#define max 100
#define SA struct sockaddr
int authentication(int sockfd){
    char password[10];
    char username[max];
    char district[10];
    char feed[max];

while(1){
    //bzero(username, sizeof(username)); //prepare memory for username
    puts("enter username");
    scanf("%s", username);
    //bzero(password, sizeof(password));
    puts("enter password");
    scanf("%s", password);
   
    puts("enter district");
    //bzero(district, sizeof(district));
    scanf("%s", district);

    char str[max];
    strcat(username, " ");
    strcat(username, password);
    strcat(username, " ");
    strcat(username, district);
  //  printf("%s and %s and %s\n", username, password, district );
//    printf("%s\n", username);
    write(sockfd, username, sizeof(username)); //send the username and password

    bzero(feed, sizeof(feed)); //receive the authentication feedback
   	read(sockfd, feed, sizeof(feed));//receive feed
   	printf("%s\n", feed);
   	if(strcmp(feed, "Success, continue")==0){
   		break;
   	}
   	printf("Validation wrong, please try again\n" );
   //then continue to the next function	
}  
   	printf("Validation successful\n"); 


}

void funcCom(int sockfd)
{
	char command[MAX];
	char feedback[MAX];
	int n;
	for (;;) {
		bzero(command, sizeof(command));//prepare memory for command

		n = 0;
		puts("enter command");
		while ((command[n++] = getchar()) != '\n')//fetch command
			;
		write(sockfd, command, sizeof(command)); //send command

		bzero(feedback, sizeof(feedback));//prepare memory for feedback
		read(sockfd, feedback, sizeof(feedback)); //store feedback in feedback
		printf("From Server : %s\n", feedback); //display feedback
	}
}

int main()
{
	int sockfd, connfd;
	struct sockaddr_in servaddr, cli;

	// socket create and varification
	sockfd = socket(AF_INET, SOCK_STREAM, 0);
	if (sockfd == -1) {
		printf("socket creation failed...\n");
		exit(1);
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
		exit(1);
	}
	else
		printf("connected to the server..\n");

	authentication(sockfd); //verify an officer first
	// function for client server communication
	funcCom(sockfd);

	// close the socket
	close(sockfd);
}


