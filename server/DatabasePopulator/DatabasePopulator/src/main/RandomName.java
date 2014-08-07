package main;

import java.util.ArrayList;
import java.util.List;

public class RandomName {

	public String first;
	public String last;

	private String fnames[] = {"John","Jane","Allan","George","Ezreal","Robert","Sue","Jack","Nikita"};

	private String lnames[] = {"Doe","Dane","Colt","Hallam","Rickman","Downey","Carr","Lee","Smith"};

	public RandomName() {
		first = fnames[randBetween(0,fnames.length-1)];
		last = lnames[randBetween(0,fnames.length-1)];
	}

	public static int randBetween(int start, int end) {
        return start + (int)Math.round(Math.random() * (end - start));
    }
}
