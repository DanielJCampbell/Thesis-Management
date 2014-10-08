package main;

public class RandomName {

	public String first;
	public String last;

	private String fnames[] = {"John","Jane","Allan","Georgie","Ezreal","Robert","Jack"};

	private String lnames[] = {"Doe","Dane","Rickman","Pie","Colt","Downey","Daniels"};

	public RandomName() {
		first = fnames[randBetween(0,fnames.length-1)];
		last = lnames[randBetween(0,fnames.length-1)];

		first = "'"+first+"'";
		last = "'"+last+"'";
	}

	public static int randBetween(int start, int end) {
        return start + (int)Math.round(Math.random() * (end - start));
    }
}
