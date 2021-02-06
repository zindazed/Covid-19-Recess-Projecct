#include<stdio.h> //including the standard input output header file
#include<stdlib.h> //including the standard library header file
#include<string.h> //including the strings header file

main(){

    FILE *fp; // declaring the file pointer
    char str[1000]; //definig string to hold patient records
    char* patientfile = "patientfile.txt"; //creating a variable name for the patient file
    char command[1000]; //defining string to get user commands
    char space = ' '; //defining the space variable
    char *criteria; // declaring the pointer to the search criteria

    puts("Enter a search command in the form _search criteria_ ");
    gets(command); //getting a command from the user
    fp = fopen(patientfile, "r"); //opening the patient file in read mode
    if (fp == NULL){
        printf("Failed to open %s",patientfile);
        exit(0); //close the program incase the file cannot be opened
    }

    criteria = strchr(command, space); //putting the criteria pointer at the start of other text after the first space in the command text

    //reading strings from the patient file
    while (fgets(str, 1000, fp) != NULL){

        //searching for the criteria in each of the reacords
        if((strstr(str,criteria)) != NULL){
        puts(str); //printing to the screen whatever string contains the required criteria
        }
    }
    fclose(fp); //close the patient file
}
