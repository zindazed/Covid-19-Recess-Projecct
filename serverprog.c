#include <stdio.h>
#include <netdb.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <mysql.h>
#include <unistd.h>
#define MAX 150
#define max 100
#define PORT 8080
#define SA struct sockaddr
//addpatientlist filename function
char *district;
void addPatientlist(int sockfd, char **patarr)
{
	FILE *fs, *ft;
	char ch;
	printf("\n%s", patarr[1]);
	int wx = strlen(patarr[1]); //stripping off the last character and assignin it to zero
    patarr[1][wx-1] = 0;
	// char *pat= patarr[1];
	// printf("\n%s", patarr[1]);
	fs = fopen(patarr[1], "r");
	if (fs == NULL){
		puts ("Cannot open source file");
		exit(1);
	}

	ft = fopen("enrollmentfile.txt", "a");//open the target file(ie; patient file)
	if (ft == NULL){
		puts ("Cannot open target file");
		exit(1);
    }
	while(1){
		ch = fgetc(fs);
		if(ch == EOF)
			break;
		else
		fputc(ch,ft);
	}
	fclose(ft);//close the patient file
	fclose(fs); //close the source file
	fs = fopen(patarr[1],"w");//reopen the source file in write mode to delete its content
	fclose(fs);//close the source file
	 //send feedback message to client
	char feedback2[MAX] = "patient-list has been added";
	write(sockfd, feedback2, sizeof(feedback2));
}

//addpatient function
void addPatient(int sockfd, char **arr2){

    FILE *fp;
    fp = fopen("enrollmentfile.txt", "a");
    if (fp == NULL){
    puts("Cannot open file");
    }
    printf("%s",arr2[5]);
    printf("%s",arr2[5]);
    int ps = strlen(arr2[5]); //stripping off the last character and assignin it to zero

    arr2[5][ps-1] = 0;
    //append the structure data into the file
    fprintf(fp,"%s %s %s %s %s %s\n", arr2[1], arr2[2], arr2[3], arr2[4], arr2[5], district);
    fclose(fp);
    char feedback[MAX] = "patient has been added";
	// sending feedback to the client
	write(sockfd, feedback, sizeof(feedback));

}

//check-status
//basher
int Check_status(int sockfd){
    int count=0; //initialising record counter
    FILE *fw; // declaring the file pointer
    char str[1000]; //definig string to hold patient records

    fw = fopen("enrollmentfile.txt", "r"); //opening the patient file in read mode
    if (fw == NULL){
        printf("Failed to open patient file");
        exit(0); //close the program incase the file cannot be opened
    }

    while (fgets(str, 1000, fw) != NULL){
        count=count+1; //counting the number of records in the patient file        }
    	//printf("%d", count);
    }
   // char hold[2] = char(count);
    printf("%d\n",count );
    fclose(fw); //close the patient file
    //sedn the number of records in the patient file to the client
    return count;
}
//search function
void search(int sockfd, char **ar){
	puts("heey");
    FILE *fr; // declaring the file pointer
    char str[1000]; //definig string to hold patient records
    fr = fopen("enrollmentfile.txt","r"); //opening the patient file in read mode
    if (fr == NULL){
        printf("Failed to open the patient file");
        exit(1); //close the program incase the file cannot be opened
    }
    int w = strlen(ar[1]); //stripping off the last character and assignin it to zero

    ar[1][w-1] = 0;
    printf("%s\n",ar[1]);
    char *ar8 = ar[1];
    printf("%s\n", ar8);//
   // printf("%s\n", sizeof(ar8));
    //reading strings from the patient file
    while (fgets(str, 1000, fr) != NULL){
    	//puts(str);
        //searching for the criteria in each of the reacords

        if((strstr(str, ar[1])) != NULL){
        	//printf("%s\n",str);
       		write(sockfd, str, sizeof(str)); //send the search query back to the client
        }
    }

        fclose(fr); //close the patient file
}

//authentication
int authenticate(int sockfd){
    char credentials[max];

    bzero(credentials, max); //prepare memory for pass
    read(sockfd, credentials, sizeof(credentials)); //read username and password from client and store it in pass
    printf("%s\n", credentials);

    char *credarr[3];//array to store strings from input
    char *s;//pointer to the delimeter
    int d = 0;
    char feed[max] = "Success, continue";
//    write(sockfd, feed, sizeof(feed));//send feed to the client
    s = strtok(credentials, " ");//getting the first token before the first delimeter using the strtok func
     // Checks for delimeter
    while (s != 0) {
     credarr[d++]=s;
     s = strtok(0, " "); //pointing to the next delimeter in the comand
    }
    district = credarr[2];
    printf("%s %s %s\n",credarr[0],credarr[1], credarr[2]);

   MYSQL *conn; //mysql connect variable
   MYSQL_RES *res;
   MYSQL_ROW row;

   char *server = "sql5.freemysqlhosting.net"; //remote mysql server address
   char *user = "sql5392531";  //remote mysql username
   char *password1 = "NcjJcFdr3c"; //remote mysql server password
   char *database = "sql5392531"; //remote mysql database name
   FILE *fp;
   conn = mysql_init(NULL); //initializing the connection variable

     //Connect to database
   puts("connecting");
   if(!mysql_real_connect(conn, server, user, password1, database, 3306, NULL, 0)){
      char error[30]="connection to database error";
      //write(sockfd, error, sizeof(error));
      fprintf(stderr, "%s\n", mysql_error(conn)); //message to client here
      exit(1);
   }
   puts("connected to remote mysql");
   char query[1024]; //buffer to store the query
   //cater for the variables to sit in the query
   //NOTE; credarr[0] is the username, and credarr[1] is the password all from client
   //building the query
   snprintf(query, sizeof(query),"SELECT officer_name, password, Retired FROM officers WHERE officer_name = ('%s') AND password = ('%s') and Retired = 0", credarr[0], credarr[1] );
   puts("validating...");
  if(mysql_query(conn, query)){
    fprintf(stderr, "%s\n", mysql_error(conn)); //message to client here
    char valid[20] = "validation failed";
    //write(sockfd, valid, sizeof(valid));
    exit(1);
    }
    //
    res = mysql_store_result(conn);
    if (res==NULL)
    {
      return 0;
    }
    int cols = mysql_num_fields(res); //counting the number of columns in result, but there is only 1 thou
    int g;
    printf("the results");
    while(row = mysql_fetch_row(res)){
        printf("\n%s\n", row[0]);
        printf("\n%s\n", row[1]);
        //row[0] contains the officer username and row[1] = contains the officer password
        //actual verification
        if((strcmp(credarr[0], row[0])==0)&&(strcmp(credarr[1], row[1])==0)){
        puts("validated");
        write(sockfd, feed, sizeof(feed));
        }else{
        	char notsucesful[max] = "validation wrong";
        	write(sockfd, notsucesful, sizeof(notsucesful));
        	exit(1);
        }
    }

    printf("success\n");
    //proceed to the rest of the program ie call funcCom()

return 0;
}

// Function designed for communication between client and server.
void func(int sockfd)
{
	char command[MAX];
	int n;
	int num;
	// char strr[20]="Addpatient";
	// char strr1[20]="Addpatientlist";
	// infinite loop
	for (;;) { //forever loop
		bzero(command, MAX);
		// read the message from client and copy it in command
		read(sockfd, command, sizeof(command));
		printf("%s\n", command);
		if ((strncmp(command, "exit", 4)) == 0) {//STOP THE PROGRAM IF COMMAND IS EXIT
			printf("serve stopped...\n");
		  	//send feedback message to client
		    char feedback0[MAX] = "server stopped";
			// sending feedback to the client
			bzero(feedback0, MAX);
			write(sockfd, feedback0, sizeof(feedback0));
			break;
			}
		//checking if command is correct
		if(strncmp("Addpatientlist", command,14)==0){ //FOR ADDPATIENTLIST
	        	printf("addpatientlist");
				char *ARR[2];//array to store strings from input
				char *p1;//pointer to the delimeter
				int y = 0;
				p1 = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
			   				 // Checks for delimeter
				while (p1 != 0) {
					ARR[y++]=p1;
				 	p1 = strtok(0, " "); //pointing to the next delimeter
				 }
				addPatientlist(sockfd, ARR); //adds patient to the patient file
			}else if(strncmp(command,"Addpatient",10)==0){ //FOR ADDPATIENT
	        //send arguments to server
				puts("addpatient");
				char *arr[5];//array to store strings from input
				char *p;//pointer to the delimeter
			    int i = 0;
			    p = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
   				 // Checks for delimeter
			    while (p != 0) {
			    	arr[i++]=p;
			        p = strtok(0, ", "); //pointing to the next delimeter in the comand
			    }
			    addPatient(sockfd, arr);//adds patient to the patient file

	        }else if(strncmp(command, "Check_status",12)==0){ //FOR CHECK_STATUS
	        	puts("check");
	        	int number = Check_status(sockfd);
		       // printf("there are %d patients in the patient file\n", Check_status());
		        char feedback3 = (char) Check_status(sockfd);
				// sending feedback to the client
				//bzero(feedback3, sizeof(feedback3));
			//	write(sockfd, feedback3, sizeof(feedback3));
	        }else if(strncmp(command, "Search",6)==0){ //FOR SEARCH
		        char *ARR3[2];//array to store strings from input
			    char *p1;//pointer to the delimeter
			    int y = 0;
			    p1 = strtok(command, " ");//getting the first token before the first delimeter using the strtok func
			    while (p1 != 0) {
			        ARR3[y++]=p1;
			        p1 = strtok(0, " "); //pointing to the next delimeter
			    }

			    printf("%s and %s", ARR3[0], ARR3[1]);
			    search(sockfd, ARR3);
		        //break;
	        }else if(strncmp(command, "help", 4)==0){//FOR HELP
	        	char feedback5[MAX] = "Check_status, help, Search <criteria>, Addpatientlist <patientlistfilename.txt>, Addpatient";
				//bzero(feedback5, MAX);
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
}

//the server main
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

	// verification of an officer
    authenticate(connfd);

	func(connfd);

	// After chatting close the socket
	close(sockfd);
}









