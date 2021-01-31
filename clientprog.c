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
	int *stringLen;
	char *string = argv[argc];
	for(int i = 1; i<=argc; i++){
    	//printf("arg %d is %s, ",i, argv[i]);
    	stringLen[i-1] = strlen(argv[i]);
    	send(sockfd, string, stringLen[i-1], 0);//sending data to the server program
	}



	// close the socket
	close(sockfd);
}
