#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <unistd.h>
#include <netdb.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#define MAX 10000
#define PORT 8080
#define max 100
#define SA struct sockaddr
#include "patientstruct.h"
char district[10];
char feedID[max];
void Addpatient(char **arr2);
int authenticate(int sockfd){
    char password[10];
    char username[max];
    int idd[max];

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

    strcat(username, " ");
    strcat(username, password);
    strcat(username, " ");
    strcat(username, district);
  //  printf("%s and %s and %s\n", username, password, district );
//    printf("%s\n", username);
    write(sockfd, username, sizeof(username)); //send the username and password

   // bzero(feed, sizeof(feed)); //receive the authentication feedback
    // bzero(idd, sizeof(idd));

    // printf("%s\n", idd);
   	read(sockfd, feedID, sizeof(feedID));//receive feed
   	printf("id is %s\n", feedID);
   	if(strcmp(feedID, "Success, continue")!=0){
   		
   		break;
   	}
//   	printf("Validation wrong, please try again\n" );
   	printf("yaay\n");
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


//CLIENT LOGIC FUNCT
void clientlogic(int sockfd){
	patient p;
	//enter the command
	char command[MAX];
	char feedback[MAX];
	int n;
	while(1){ //forever loop for communication
		bzero(command, MAX);
		n = 0;
		puts("enter command");
		while ((command[n++] = getchar()) != '\n')//fetch command from user
			;
		if(strncmp("Addpatientlist", command,14)==0){
			//send the Addpatient command
			write(sockfd, command, sizeof(command));
		}else if(strncmp(command,"Addpatient",10)==0){
				int len;
				len = strlen(command);
				if(len>25){
					//execute the addpatient namw, category, func
					while(1){
					char *arr[5];//array to store strings from input
					char *p;//pointer to the delimeter
				    int i = 0;
				    p = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
		   			 // Checks for delimeter
				    while (p != 0) {
				    	arr[i++]=p;
				        p = strtok(0, ", "); //pointing to the next delimeter in the comand
				    }
				   // printf("\n%d\n ", i);
					FILE *fr;
				    fr = fopen("patientlist.txt", "a");
				    if (fr == NULL){
				    puts("Cannot open file");
				    }
				    //printf("%s",arr[5]);
				    int ps = strlen(arr[5]); //stripping off the last character and assignin it to zero

				    arr[5][ps-1] = 0;
				    if(i>2){
				    	//addpatient to list
		  				fprintf(fr,"%s %s %s %s %s %s %s\n", arr[1], arr[2], arr[3], arr[4], arr[5], district, feedID);
		  				puts("patient added");
				    }else{
				    	//this should be the addpatient <filename> command
				    	puts("addpatient filename entered");
				    	write(sockfd, command, sizeof(command)); //send the addpatient<filename> command
				    	break; //jump outta loop
				    }
				    fclose(fr);
				    //enter another command
				    int f;
				    bzero(command, MAX);
				    f =0;
				    puts("enter command");
					while ((command[f++] = getchar()) != '\n')//fetch command
							;
					if(strncmp("Addpatientlist", command,14)==0){
						//puts("addpatientlist entered");
						write(sockfd, command, sizeof(command));
						break; //jumpt outta loop
					}else if(strncmp(command,"Addpatient",10)==0){
						continue;//continue with adding patients
					}else{
						//send anyother command
						write(sockfd, command, sizeof(command));
						break;
					}
					continue;
					}
			    }else{
					//send the addpatient <filename.> command
					// puts("addpatient filename command");
					write(sockfd, command, sizeof(command));
				}

		}else{
			//send the other command
			write(sockfd, command, sizeof(command));
		}

	//receive feedback
	bzero(feedback, sizeof(feedback));//prepare memory for feedback
	//check is feedback is a multiple feedback
	read(sockfd, feedback, sizeof(feedback)); //store feedback in feedback
	printf("From Server : %s\n", feedback); //display feedback
	}
}

//ADDPATIENT FUNCT
// void Addpatient(char **arr2){
// 	FILE *fp;
//     fp = fopen("patientlist.txt", "a");
//     if (fp == NULL){
//     puts("Cannot open file");
//     }
//     printf("%s",arr2[5]);
//     printf("%s",arr2[5]);
//     int ps = strlen(arr2[5]); //stripping off the last character and assignin it to zero

//     //arr2[5][ps-1] = 0;
//     //append the structure data into the file
//     fprintf(fp,"%s %s %s %s %s %s\n", arr2[1], arr2[2], arr2[3], arr2[4], arr2[5], district, feedID);
//     fclose(fp);
//     puts("patient added");
// }

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

	authenticate(sockfd); //verify an officer first
	// function for client server communication
	clientlogic(sockfd);

	// close the socket
	close(sockfd);
}



