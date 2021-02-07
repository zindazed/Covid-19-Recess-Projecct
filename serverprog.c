#include <stdio.h>
#include <netdb.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#define MAX 150
#define PORT 8080
#define SA struct sockaddr

//addpatientlist filename function
void addPatientlist(char **arr)
{
	FILE *fs, *ft;
	char ch;
	fs = fopen (arr[1], "r");
	if (fs == NULL){
		puts ("Cannot open source file");
		exit(1);
	}

	ft = fopen ("patient.txt", "a");
	if (ft == NULL){
		puts ("Cannot open target file");
		fclose(fs);
		exit(1);
	}

	while(1){
		ch = fgetc(fs);
		if(ch == EOF)
		break ;
		else
		fputc(ch,ft);
	}
	fclose(fs);
	fclose(ft);
}
void addPatient(char **arr2){

    FILE *fp;
    fp = fopen("patient.txt", "a");
    if (fp == NULL){
    puts("Cannot open file");
    }
    //append the structure data into the file
    fprintf(fp,"%s\t%s\t%s\t%s", arr2[1], arr2[2], arr2[3], arr2[4]);

    fclose(fp);
}

//check-status
//basher
int Check_status(){
    int count=0; //initialising record counter
    FILE *fp; // declaring the file pointer
    char str[1000]; //definig string to hold patient records

    fp = fopen("patient.txt", "r"); //opening the patient file in read mode
    if (fp == NULL){
        printf("Failed to open patient file");
        exit(0); //close the program incase the file cannot be opened
    }

    while (fgets(str, 1000, fp) != NULL){
        count=count+1; //counting the number of records in the patient file        }
    	printf("%d", count);
    }
    fclose(fp); //close the patient file
    //sedn the number of records in the patient file to the client
    return count;
}
//search function
void search(char **ar){
       FILE *fp; // declaring the file pointer
    char str[1000]; //definig string to hold patient records
        fp = fopen("patient.txt","r"); //opening the patient file in read mode
    if (fp == NULL){
        printf("Failed to open the patient file");
        exit(0); //close the program incase the file cannot be opened
    }
    //reading strings from the patient file
    while (fgets(str, 1000, fp) != NULL){
        //searching for the criteria in each of the reacords
        if((strstr(str,ar[1])) != NULL){
        puts(str); //printing to the screen whatever string contains the required criteria
        }
    }
        fclose(fp); //close the patient file
}
// Function designed for communication between client and server.
void func(int sockfd)
{
	char command[MAX];
	int n;
	int num;
	// infinite loop
	for (;;) { //forever loop
		bzero(command, MAX);
			if ((strncmp(command, "exit", 4)) == 0) {
			printf("serve stopped...\n");
		  	//send feedback message to client
		    char feedback0[MAX] = "server stopped";
			// sending feedback to the client
			bzero(feedback0, MAX);
			write(sockfd, feedback0, sizeof(feedback0));
			break;
			}
		// read the message from client and copy it in command
		read(sockfd, command, sizeof(command));

		//checking if command is correct
			if(strncmp(command, "Addpatient",10)==0){ //FOR ADDPATIENT
	        //send arguments to server
				char *arr[4];//array to store strings from input
				char *p;//pointer to the delimeter
			    int i = 0;
			    p = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
   				 // Checks for delimeter
			    while (p != 0) {
			    	arr[i++]=p;
			        p = strtok(0, ", "); //pointing to the next delimeter in the comand
			    }
			    addPatient(arr);//adds patient to the patient file
			    char feedback[MAX] = "patient has been added";
				// // sending feedback to the client
				//bzero(feedback1, MAX);
				write(sockfd, feedback, sizeof(feedback));
	        }else if(strncmp(command, "Addpatientlist",14)==0){ //FOR ADDPATIENTLIST
	        //send stdering to server program
				char *ARR[1];//array to store strings from input
				char *p1;//pointer to the delimeter
			    int y = 0;
			    p1 = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
   				 // Checks for delimeter
			    while (p1 != 0) {
			    	ARR[y++]=p1;
			        // Use of strtok
			        // go through other tokens
			        p1 = strtok(0, " "); //pointing to the next delimeter
			    }
			    addPatientlist(ARR);//adds patient to the patient file
	        	//send feedback message to client
	        	char feedback2[MAX] = "patient list has been added";
				// // sending feedback to the client
				//bzero(feedback2, MAX);
				write(sockfd, feedback2, sizeof(feedback2));
	        }else if(strncmp(command, "Check_status",12)==0){ //FOR CHECK_STATUS
	        	int number = Check_status();
		       // printf("there are %d patients in the patient file\n", Check_status());
		        char feedback3 = (char) Check_status();
				// sending feedback to the client
				//bzero(feedback3, sizeof(feedback3));
				write(sockfd, feedback3, sizeof(feedback3));
	        }else if(strncmp(command, "Search",6)==0){ //FOR SEARCH
		        char *ARR3[1];//array to store strings from input
			    char *p1;//pointer to the delimeter
			    int y = 0;
			    p1 = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
			    while (p1 != 0) {
			        ARR3[y++]=p1;
			        p1 = strtok(0, " "); //pointing to the next delimeter
			    }
			    search(ARR3);
		        //break;
	        }else if(strncmp(command, "help", 4)==0){//FOR HELP
	        	char feedback5[MAX] = "Check_status, help, Search <criteria>, Addpatientlist <patientlistfilename.txt>, Addpatient";
				// // sending feedback to the client
				Check_status();
				bzero(feedback5, MAX);
				write(sockfd, feedback5, sizeof(feedback5));
	        }else { //IF COMMAND IS WRONG
		       	char feedback6[MAX] = "the command you have entered is wrong, check your command again. type 'help' to list the commands available";
				// // sending feedback to the client
				bzero(feedback6, MAX);
				write(sockfd, feedback6, sizeof(feedback6));
	        //puts("you have entered a wrong command\n to show commands available");
	        //puts("commands available\n1. Addpatient patientname, dtae, gender, category\n2. Addpatientlist\n3. Check_status\n4. Search <criteria>\n5. Addpatient filename.txt");
        	}
  	}

		// and send that buffer to client
		write(sockfd, command, sizeof(command));
}


//func decs
// Driver function
int main()
{
	int sockfd, connfd, len;
	struct sockaddr_in servaddr, cli;

	// socket create and verification
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
	servaddr.sin_addr.s_addr = htonl(INADDR_ANY);
	servaddr.sin_port = htons(PORT);

	// Binding newly created socket to given IP and verification
	if ((bind(sockfd, (SA*)&servaddr, sizeof(servaddr))) != 0) {
		printf("socket bind failed...\n");
		exit(0);
	}
	else
		printf("Socket successfully binded..\n");

	// Now server is ready to listen and verification
	if ((listen(sockfd, 5)) != 0) {
		printf("Listen failed...\n");
		exit(0);
	}
	else
		printf("Server listening..\n");
	len = sizeof(cli);

	// Accept the data packet from client and verification
	connfd = accept(sockfd, (SA*)&cli, &len);
	if (connfd < 0) {
		printf("server acccept failed...\n");
		exit(0);
	}
	else
		printf("server acccept the client...\n");

	// verification

	// Function for chatting between client and server
	func(connfd);

	// After chatting close the socket
	close(sockfd);
}








