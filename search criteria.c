#include<stdio.h> //including the standard input output header file
#include<stdlib.h> //including the standard library header file

main(){
    FILE *fp; // declaring the file pointer
    char str[1000]; //definig string to hold patient records
    char* patientfile = "patientfile.txt"; //creating a variable name for the patient file

    fp = fopen(patientfile, "r"); //opening the patient file in read mode
    if (fp == NULL){
        printf("Failed to open %s",patientfile);
        exit(0); //close the program incase the file cannot be opened
    }

    while (fgets(str, 1000, fp) != NULL){
        puts(str);
    }
    fclose(fp); //close the patient file
}
