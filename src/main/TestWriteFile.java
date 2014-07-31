package main;

import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;


public class TestWriteFile {

    public static void main(String[] args) {    	
    	PrintWriter writer = null;
		try {
			writer = new PrintWriter("test-data.txt", "UTF-8");


			MyWriter w = new MyWriter(writer);
    	writer.close();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (UnsupportedEncodingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    }
}